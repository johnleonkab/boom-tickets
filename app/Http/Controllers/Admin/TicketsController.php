<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UrlController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Session;
use Auth;
use Illuminate\Support\Facades\DB;


use App\Models\Event;
use App\Models\Admin;
use App\Models\Ticket;

class TicketsController extends Controller
{
    public function ReturnValidationError($validation_errors){
        
        return back()->with('error', 'Ha habido un problema con los datos introducidos: '. $validation_errors);
    }


    public function CreateStripePrice($data){
        $stripe = new \Stripe\StripeClient(
            'sk_test_51KBkfqEG9rwSgs2lOK451W7QCG6rLgaHh4hyViBz0CFdrTpAOMQ7cU8ZcHTf9BRrD1O6TU3OeUm2HecygXihL0s300iPUhLb3M'
          );
        $price = $stripe->prices->create([
            'unit_amount' => $data->price->unit_amount,
            'currency' => $data->price->currency,
            'product' => $data->product->id
          ]);
          if(!$price){
            return false;
        }
        $response = $price;
        return $response;
    }

    public function UpdateStripePrice( $product_id, $price_id, $data){
        $stripe = new \Stripe\StripeClient(
            'sk_test_51KBkfqEG9rwSgs2lOK451W7QCG6rLgaHh4hyViBz0CFdrTpAOMQ7cU8ZcHTf9BRrD1O6TU3OeUm2HecygXihL0s300iPUhLb3M'
          );
          $price = $stripe->prices->update(
            $price_id,
            [
                'active' => false
                    ]);

        $price = $stripe->prices->create([
            'unit_amount' => $data->price->unit_amount,
            'currency' => $data->price->currency,
            'product' => $product_id
            ]);
            if(!$price){
            return false;
        }
        $response = $price;
        return $response;
    }

    public function CreateUpdateTicket(Request $request){
        #Validar todos los datos:
        $validator = Validator::make($request->all(), [
            'event_slug' => 'required|exists:events,slug',
            'slug' => 'exists:tickets,slug',
            'name' => 'required|max:25',
            'conditions' => 'required',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|min:3|max:3',
            'quantity' => 'required|numeric|integer|min:1',
            'people_per_ticket' => 'required|numeric|integer|min:1',
            'time_limit' => 'required|boolean',
            'id_number_required' => 'required|boolean',
        ]);
        if($validator->fails()){
            return $this->ReturnValidationError($validator->errors());
        }
        
        $event = Event::where('slug', $request->event_slug)->first();
        

        if($request->has('slug')){
            $slug = $request->slug;
        }else{
            $slug = "ti_".UrlController::slugGenerate(Admin::find(Auth('admin')->user()->id)->organization->slug."-".$request->name, 'tickets');
        }

        if($event->visible){
            return $this->ReturnValidationError('No se puede editar ni añadir una entrada a un evento público');
        }
        
        if($request->time_limit){
            $validator = Validator::make($request->all(), [
                'max_datetime' => 'required|date_format:Y-m-d\TH:i'
            ]);
            if($validator->fails()){
                return $this->ReturnValidationError($validator->errors());
            }
            $timezone = 'Europe/Madrid';
            if(Carbon::createFromFormat('Y-m-d\TH:i', $request->max_datetime, $timezone) <= Carbon::createFromFormat('Y-m-d H:i:s', $event->start_datetime, $timezone)){
                return $this->ReturnValidationError('Error: La fecha maxima de entrada debe ser mayor que la fecha de inicio del evento');
            }
            if(Carbon::createFromFormat('Y-m-d\TH:i', $request->max_datetime, $timezone) > Carbon::createFromFormat('Y-m-d H:i:s', $event->end_datetime, $timezone)){
                return $this->ReturnValidationError('Error: La fecha maxima de entrada debe ser MENOR que la fecha FINAL del evento');
                
            }
        }

        //$ticketsNumber = Event::find($event->id)->tickets->sum('number');
        $Slug2 = $request->slug;
        $amount =  Ticket::where('event_id', $event->id)->where('slug', '<>', $Slug2)->select(DB::raw('sum(quantity * people_per_ticket) as total'))->get()->first();
        $ticketsNumber = $amount->total;
        if($ticketsNumber + ($request->quantity * $request->people_per_ticket) > $event->max_capacity){
            return $this->ReturnValidationError('El número de entradas que intentas sacar es superior a la capacidad máxima del evento.');
        }
        

        if(!$request->has('slug')){
            //Nuevo ticket
            $event = Event::where('slug', $request->event_slug)->first();
            $unit_amount = $request->price*100;
            $data = new \stdClass();
            $data->product = new \stdClass();
            $data->price = new \stdClass();
            $data->price->metadata = new \stdClass();
            $data->product->id = $event->stripe_product_id;
            $data->price->unit_amount = $unit_amount;
            $data->price->metadata->name = $request->name;
            $data->price->metadata->conditions = $request->conditions;
            $data->price->currency = 'eur';

            $stripeCreate = $this->CreateStripePrice($data);
            if(!$stripeCreate){
                return $this->ReturnValidationError('No se pudo crear la entrada.');
            }
            $price_id = $stripeCreate->id;
        }else{
            // update ticket
            $slug = $request->slug;
            $product_id = $event->stripe_product_id;
            $price_id = Ticket::where('slug', $slug)->first()->stripe_price_id;

            $unit_amount = $request->price*100;
            $data = new \stdClass();
            $data->product = new \stdClass();
            $data->price = new \stdClass();
            $data->price->metadata = new \stdClass();
            $data->price->unit_amount = $unit_amount;
            $data->price->metadata->name = $request->name;
            $data->price->metadata->conditions = $request->conditions;
            $data->price->currency = 'eur';

            $stripeUpdate = $this->UpdateStripePrice($product_id, $price_id,$data);
            if(!$stripeUpdate){
                return $this->ReturnValidationError('No se psudo actualizar la entrada.');
            }
            $price_id = $stripeUpdate->id;
        }

        $timezone = $event->venue->timezone;
        $max_datetime = null;
        if($request->time_limit){
            $max_datetime = Carbon::createFromFormat('Y-m-d\TH:i', $request->max_datetime, $timezone)->setTimezone('UTC');
        }
        //Insert new tickets;
        $create = Ticket::updateOrCreate(
            ['slug' => $request->slug, 'event_id' => $event->id],
            [
            'stripe_price_id' => $price_id, 
            'slug' => $slug,
            'name' => $request->name,
            'conditions' => $request->conditions,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'currency' => $request->currency,
            'event_id' => $event->id,
            'visible' => true,
            'time_limit' => $request->time_limit,
            'max_datetime' =>  $max_datetime,
            'people_per_ticket' => $request->people_per_ticket,
            'id_number_required' => $request->id_number_required,
        ]);

        Session::put('success','Entrada creada con éxito.');  
        return redirect(url('admin/event/'.$event->slug));;
    }

    public function DeleteTicket(Request $request){
        $validator = Validator::make($request->all(), [
            'slug' => 'required|exists:tickets,slug'
        ]);
        if($validator->fails()){
            $this->ReturnValidationError('No se ha encontrado la entrada que quieres eliminar.');
        }

        //Check that tickets belongs to user organization.
        $ticket = Ticket::where('slug', $request->slug)->first();
        if($ticket->event->organization->id != Auth::guard('admin')->user()->organization_id){
            return $this->ReturnValidationError('No hemos podido verificar que pertenezcas a la organización de la entrada que quieres
            eliminar.');
        }
        //Delete ticket from database and stripe:
        $stripe = new \Stripe\StripeClient(
            'sk_test_51KBkfqEG9rwSgs2lOK451W7QCG6rLgaHh4hyViBz0CFdrTpAOMQ7cU8ZcHTf9BRrD1O6TU3OeUm2HecygXihL0s300iPUhLb3M'
          );
          $price = $stripe->prices->update(
            $ticket->stripe_price_id,
            [
                'active' => false
                    ]);
        $deleteFromDatabase = Ticket::find($ticket->id);
        $deleteFromDatabase->delete();
        Session::put('success','Entrada eliminada correctamente');  
        return redirect(url('admin/event/'.$ticket->event->slug));
    }

}
