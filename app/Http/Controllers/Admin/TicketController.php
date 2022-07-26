<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;


use App\Models\Event;
use App\Models\Ticket;
use App\Http\Controllers\UrlController;
use App\Models\Admin;

class TicketController extends Controller
{
    public function newTicket(Request $request){
//  #1 Validate
        $validator = Validator::make($request->all(),
        [
            'name' => 'required|max:25',
            'conditions' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|numeric',
            'event_slug' => 'required|exists:events,slug',
            'visible' => 'required|boolean',
            'time_limit' => 'required|boolean',
            'id_number_required' => 'required|boolean',
        ]
        );
        if ($validator->fails())
        {
            return back()->with('error', 'Ha habido un error y la entrada no se ha podido crear.');
        }
        if($request->time_limit == 1){
            $validator = Validator::make($request->all(),
            [

                'max_datetime' => 'required|date_format:Y-m-d\TH:i|',
            ]);
            if ($validator->fails())
            {
                return back()->with('error', 'Ha habido un error y la entrada no se ha podido crear.');
            }
            //Check ticket max date time is between the time of the party;
            $event = Event::where('slug', $request->event_slug)->get()->first();
            $timezone = $event->venue->timezone;

            if(Carbon::createFromFormat('Y-m-d\TH:i', $request->max_datetime, $timezone) <= Carbon::createFromFormat('Y-m-d H:i:s', $event->start_datetime, $timezone)){
                return back()->with('error', 'La fecha maxima de entrada debe ser mayor que la fecha de inicio del evento');
            }
            if(Carbon::createFromFormat('Y-m-d\TH:i', $request->max_datetime, $timezone) > Carbon::createFromFormat('Y-m-d H:i:s', $event->end_datetime, $timezone)){
                return back()->withInput()->with('error', 'La fecha maxima de entrada debe ser MENOR que la fecha FINAL del evento');
            }
            
            

        }

        //Checking number of intended tickets doesnt surpass event maximum.´
        $event = Event::where('slug', $request->event_slug)->get()->first();
        //$ticketsNumber = Event::find($event->id)->tickets->sum('number');
        $amount =  Ticket::where('event_id', $event->id)->select(DB::raw('sum(quantity * people_per_ticket) as total'))->get()->first();
        $ticketsNumber = $amount->total;
        if($ticketsNumber + ($request->quantity * $request->people_per_ticket) > $event->max_capacity){
            return back()->with('error', 'El número de entradas que intentas sacar es superior a la capacidad máxima del evento.');
        }
    
        // insert to stripe
        $stripe = new \Stripe\StripeClient('sk_test_4eC39HqLyjWDarjtT1zdp7dc');
        $product = $stripe->products->create([
            'name' => $event->name." - ".$request->name,
            'description' => $event->description,
            'metadata' => [
                'start_datetime' => $event->start_datetime, 
                'end_datetime' => $event->end_datetime,
                'max_entry_datetime' => $request->max_datetime 
            ]  
        ]);
        $price = $request->price*100;
        $stripe = new \Stripe\StripeClient('sk_test_4eC39HqLyjWDarjtT1zdp7dc');
        $price = $stripe->prices->create([
            'unit_amount' => $price,
            'currency' => 'eur',
            'recurring' => ['interval' => 'month'],
            'product' => 'prod_M5mrbk8BGScb2Q',
          ]);

        //Insert new tickets;
        $slug = UrlController::slugGenerate(Admin::find(Auth('admin')->user()->id)->organization->slug."-".$request->name, 'tickets');
        $create = Ticket::create([
            'stripe_product_id' => $product->id, 
            'slug' => $slug,
            'name' => $request->name,
            'conditions' => $request->conditions,
            'price' => $request->price,
            'quantity' => $request->number,
            'event_id' => $event->id,
            'visible' => $request->visible,
            'time_limit' => $request->time_limit,
            'max_datetime' => $request->max_datetime,
            'people_per_ticket' => $request->people_per_ticket,
            'id_number_required' => $request->id_number_required,
        ]);

        Session::put('success','Entrada creada con éxito.');  
        return redirect(url('admin/event/'.$event->slug));;
        
    }

    public function updateTicket(Request $request){
        /*  RULES 
        A ticket can't be edited once it has been released (User purchase includes ticket data.)
        As long as the ticket has not been released, it can be fully edited.
        */
        #1 Validate
        $validator = Validator::make($request->all(),
        [
            'slug' => 'required|max:40|exists:tickets,slug',
            'name' => 'required|max:25',
            'conditions' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|numeric',
            'visible' => 'required|boolean',
            'time_limit' => 'required|boolean',
            'id_number_required' => 'required|boolean',
        ]);
        if ($validator->fails())
        {
            return back()->with('error', 'Ha habido un error con los datos enviados y la entrada no ha podido actualizarse. Revisa los campos.');
        }

        if($request->time_limit == 1){
            $validator = Validator::make($request->all(),
            [

                'max_datetime' => 'required|date_format:Y-m-d\TH:i',
            ]);
            if ($validator->fails())
            {
                return back()->with('error', 'Ha habido un error con el formato de la fecha y hora máximos.');
            }
            $event = Ticket::where('slug', $request->slug)->get()->first();
            if(Carbon::parse($request->max_datetime)->format('Y-m-d H:i') < Carbon::parse($event->start_date_time)->format('Y-m-d H:i')){
                return back()->with('error', 'La fecha y hora de entrada máximos deben ser mayores que la fecha de inicio del evento');
            }
            if(Carbon::parse($request->max_datetime)->format('Y-m-d H:i') > Carbon::parse($event->end_date_time)->format('Y-m-d H:i')){
                return back()->with('error', 'La fecha y hora de entrada máximos deben ser menores que la fecha de finalización del evento');
            }
        }

        #2 Checking if ticket is editable or not.
        $ticket =  Ticket::where('slug', $request->slug)->get()->first();
        if($ticket->visible == true && Event::find($ticket->event_id)->visible){
            return back()->with('error', 'No puedes editar una entraba publicada. Puede haber usuarios que la hayan comprado.');
        }

        #3 Checking number of intended tickets does not surpass event maximum.
        $eventId = Ticket::where('slug', $request->slug)->get()->first()->event_id;
        $event = Event::find($eventId);
        $ticketsNumber = Event::find($eventId)->tickets->where('slug', '<>', $request->slug)->sum('number');
        if($ticketsNumber + $request->number > $event->max_capacity){
            return back()->with('error', 'El número de entradas que intentas sacar es superior a la capacidad máxima del evento.');
        }

        #4 Check if ticket belongs to same organization as admin.
        $ticketOrganization = Ticket::where('slug', $request->slug)->get()->first()->event->organization->id;
        if($ticketOrganization !=  Admin::find(Auth('admin')->user()->id)->organization_id){
            return back()->with('error', 'No puedes editar una entrada de un evento externo a tu organización.');
        }
        
        #5 Update fields.
        $update = Ticket::where('slug', $request->slug)
            ->update([
                'name' => $request->name,
                'conditions' => $request->conditions,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'visible' => $request->visible,
                'time_limit' => $request->time_limit,
                'max_datetime' => $request->max_datetime,
                'id_number_required' => $request->id_number_required,
            ]);

        Session::put('success','Entrada actualizada con éxito');  
        return redirect(url('admin/event/'.Ticket::where('slug', $request->slug)->get()->first()->event->slug));
    }
    
    public function deleteTicket(Request $request){
        #1 Validate
        $validator = Validator::make($request->all(),
            [
                'slug' => 'required|max:40|exists:tickets,slug',
            ]
            );

        if ($validator->fails())
        {
            return back()->with('error', 'Ha habido un error y la entrada no se ha podido eliminar.');
        }

        $ticket = Ticket::where('slug', $request->slug)->get()->first();
        #2 Ticket is not public
        if($ticket->visible && Event::find($ticket->event_id)->visible){
            return back()->with('error', 'No se pueden eliminar entradas publicadas. Puede ser que ya se hayan vendido existencias.');
        }

        #4 Ticket belongs to admin organization.
        if($ticket->event->organization_id !=  Admin::find(Auth('admin')->user()->id)->organization_id){
            return back()->with('error', 'No puedes eliminar una entrada de un evento externo a tu organización.'); 
        }

        #5 Delete ticket 
        $delete = Ticket::find($ticket->id);
        $delete->delete();
        Session::put('success','Entrada eliminada correctamente');  
        return redirect(url('admin/event/'.$ticket->event->slug));
    }
}
