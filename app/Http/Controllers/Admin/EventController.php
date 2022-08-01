<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UrlController;
use App\Models\Event;
use App\Models\Admin;
use App\Models\Venue;
use App\Models\Ticket;
use Auth;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{

    public function ReturnValidationError($validation_errors){
        return back()->with('error',  $validation_errors);
    }

    public function FindVenue($venue_slug){
        $venue = Venue::where('slug', $venue_slug)
            ->where('organization_id', Admin::find(Auth('admin')->user()->id)->organization->id)
            ->get();
        if($venue->isEmpty()){
            return false;
        }
        $venue = $venue->first();
        if($venue->organization_id != Admin::find(Auth('admin')->user()->id)->organization->id){
            return false;
        }
        return $venue;
    }


    public function NewEvent(Request $request){
        $validator = Validator::make($request->all(),
        [
            'name' => 'required|max:100',
            'description' => 'required|max:6000',
            'start_date_time' => 'required|date_format:Y-m-d\TH:i',
            'end_date_time' => 'required|date_format:Y-m-d\TH:i|after_or_equal:start_date_time',
            'max_capacity' => 'required|numeric|min:0|integer',
            /*'recurrente' => 'required|boolean',*/
            'patron_recurrencia' => 'max:255',
            'venue_slug' => 'required|exists:venues,slug',
            'color' => 'required|max:6|in:red,green,blue,purple,pink',
            'minimum_age' => 'required|numeric|min:18|integer',
        ]);

        if ($validator->fails()){
            return $this->ReturnValidationError('Ha habido un problema con los datos introducidos:'.$validator->errors());
        }
        
        $array = json_decode($request->tags);
        $TagsArray;
        foreach($array as $tag){
            $TagsArray[] = $tag->value;
        }
        $tagsString = implode(',', $TagsArray);

        #3 Make sure venue belongs to admin organization and get id
        if($this->FindVenue($request->venue_slug) == false){
            return $this->ReturnValidationError('No se ha podido verificar que la localización pertenezca a tu organización');
        }

        #2  Validate start_date
        $timezone = $this->FindVenue($request->venue_slug)->timezone;
        if(Carbon::createFromFormat('Y-m-d\TH:i', $request->start_date_time, $timezone) < Carbon::now()){
            return $this->ReturnValidationError('Error: La fecha de inicio debe ser posterior a ahora mismo');
        }

        #4 Generate slug
        $slug = 'ev_'.UrlController::slugGenerate($request->name, 'events');

        $poster_url = "";
        if($request->hasFile('poster_img')){
            $file = $request->file('poster_img');
            $filename = "img_".$slug. '.' . $file->extension();
            $file->storeAs('public/events/',$filename);
            $poster_url = $filename;
        }


        #Create stripe product:
        $stripe = new \Stripe\StripeClient('sk_test_51KBkfqEG9rwSgs2lOK451W7QCG6rLgaHh4hyViBz0CFdrTpAOMQ7cU8ZcHTf9BRrD1O6TU3OeUm2HecygXihL0s300iPUhLb3M');
        $product = $stripe->products->create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        if(!$product){
            return $this->ReturnValidationError('No se ha podido crear el evento correctamente');
        }

        
        #4 Insert event in database
        $create = Event::create([
            'stripe_product_id' => $product->id,
            'slug' => $slug,
            'name' => $request->name,
            'description' => $request->description,
            'tags' => $tagsString,
            'start_datetime' => Carbon::createFromFormat('Y-m-d\TH:i', $request->start_date_time, $timezone)->setTimezone('UTC'),
            'end_datetime' => Carbon::createFromFormat('Y-m-d\TH:i', $request->end_date_time, $timezone)->setTimezone('UTC'),
            'max_capacity' => $request->max_capacity,
            'visible' => false,
            'recurrente' => 0,
            'patron_recurrencia' => $request->patron_recurrencia,
            'venue_id' => $this->FindVenue($request->venue_slug)->id,
            'color' => $request->color,
            'poster_url' => env('APP_URL').'/storage/events/'.$poster_url,
            'organization_id' => Admin::find(Auth('admin')->user()->id)->organization_id,
            'minimum_age' => $request->minimum_age
        ]);

        #5 Return to event view
        Session::put('success','Evento creado con éxito');  
        return redirect(url('admin/event/'.$slug));
    }

    public function publishEvent(Request $request){
        $validator = Validator::make($request->all(),
        [
            'slug' => 'required|exists:events,slug'
        ]);
        if($validator->fails()){
            return $this->ReturnValidationError('No existe el evento');
        }
        $event = Event::where('slug', $request->slug)->first();
        $numberOfPeopleTickets = Ticket::where('event_id', $event->id)->where('visible', true)
        ->select(DB::raw('sum(quantity * people_per_ticket) as total'))->first();
        if($numberOfPeopleTickets->total < $event->max_capacity){
            return $this->ReturnValidationError('No puedes publicar un evento donde faltan entradas para llegar al aforo.');
        }
        $publish = Event::where('slug', $request->slug)->update([
            'visible' => true
        ]);
        Session::put('success','Evento publicado con éxito'); 
        return redirect(url('admin/event/'.$request->slug));
    }

    public function UpdateEvent(Request $request){
        #1 Validate all inputs
        $validator = Validator::make($request->all(),
            [
                'slug' => 'required|max:40|exists:events,slug',
                'name' => 'required|max:100',
                'description' => 'required|max:1000',
                'start_date_time' => 'required|date_format:Y-m-d\TH:i',
                'end_date_time' => 'required|date_format:Y-m-d\TH:i|after_or_equal:start_date_time',
                'max_capacity' => 'required|numeric|min:0|max:9999',
                'recurrente' => 'boolean',
                'patron_recurrencia' => 'max:255',
                'venue_slug' => 'required|exists:venues,slug',
                'color' => 'required|max:6|in:red,blue,yellow,green,lime,violet,purple,orange,cian,aqua',
                'minimum_age' => 'required|numeric|min:18',
            ]
            );

        if ($validator->fails())
        {
            return back()->with('error', 'Ha habido un error de validación y el evento no se ha podido actualizar.'.$validator->errors());
        }

        $array = json_decode($request->tags);
        $TagsArray;
        foreach($array as $tag){
            $TagsArray[] = $tag->value;
        }
        $tagsString = implode(',', $TagsArray);
        #2 Check if event belongs to admin organization
        $event = Event::where('slug', $request->slug)->where('organization_id', Admin::find(Auth('admin')->user()->id)->organization_id)->get();
        if($event->isEmpty()){
            return back()->with('error', 'No se ha encontrado el evento, prueba con otro.');
        }
        #3 Check if event can be fully edited or not
        #4.1. If event is partially editable
        #4.2. If event is fully editable
        #4.2.1. Make sure venue belongs to admin organization and get id


        
        #2 Find if Event is visible or not.
        $event = Event::where('slug', $request->slug)
        ->where('organization_id', Admin::find(Auth('admin')->user()->id)->organization_id)
        ->get()->first();

        $poster_url = $event->poster_url;
        if($request->hasFile('poster_img')){
            $file = $request->file('poster_img');
            $filename = "img_".$request->slug. '.' . $file->extension();
            $file->storeAs('public/events/',$filename);
            $poster_url = env('APP_URL').'/storage/events/'.$filename;
        }

        if(!$event->visible){
         //Event can be fully edited

            #3 Check venue belongs to organization.
            $venue = Venue::where('slug', $request->venue_slug)->where('organization_id', Admin::find(Auth('admin')->user()->id)->organization->id)->get()->first();
            //Make sure venue belongs to organization:
            if($venue->organization_id != Admin::find(Auth('admin')->user()->id)->organization->id){
                return back()->with('error', 'No se ha podido verificar que la localización pertenezca a tu organización');
            }

         $update = Event::where('slug', $request->slug)->where('organization_id', Admin::find(Auth('admin')->user()->id)->organization->id)
            ->update([
                'name' => $request->name,
                'description' => $request->description,
                'tags' => $tagsString,
                'start_datetime' => Carbon::createFromFormat('Y-m-d\TH:i', $request->start_date_time, $venue->timezone)->setTimezone('UTC'),
                'end_datetime' => Carbon::createFromFormat('Y-m-d\TH:i', $request->end_date_time, $venue->timezone)->setTimezone('UTC'),
                'max_capacity' => $request->max_capacity,
                'visible' => $event->visible,
                'recurrente' => false,
                'patron_recurrencia' => $request->patron_recurrencia,
                'venue_id' => $venue->id,
                'color' => $request->color,
                'poster_url' => $poster_url,
                'minimum_age' => $request->minimum_age

            ]);
         Session::put('success','Evento actualizado con éxito');  
         return redirect(url('admin/event/'.$request->slug));
        }
    
        //Only update allowed fields:
        $update = Event::where('slug', $request->slug)->where('organization_id', Admin::find(Auth('admin')->user()->id)->organization->id)
            ->update([
                'name' => $request->name,
                'description' => $request->description,
                'color' => $request->color,
                'tags' => $tagsString,
                'poster_url' => $poster_url,
            ]);
        Session::put('success','Evento actualizado con éxito');  
        return redirect(url('admin/event/'.$request->slug));


        #4 Venue belongs to organization



            
    }

    public function deleteEvent(Request $request){
        $validator = Validator::make($request->all(),
            [
                'slug' => 'required|max:40',
            ]
            );

        if ($validator->fails())
        {
            return back()->with('error', 'Ha habido un error y el evento no se ha podido eliminar.');
        }
        //Make sure Event belongs to organization:
        if(Event::where('slug', $request->slug)->limit(1)->get()->first()->organization_id != Admin::find(Auth('admin')->user()->id)->organization->id){
            return back()->with('error', 'No se ha podido verificar que el evento pertenezca a tu organización');
        }
        $event = Event::where('slug', $request->slug)->where('organization_id', Admin::find(Auth('admin')->user()->id)->organization->id);
        $event->delete();
        Session::put('success','Evento eliminado correctamente');  
        return redirect(url('admin/events/'));
    }


    public function LoadEvents(){
        $events = Event::where('organization_id', Admin::find(Auth('admin')->user()->id)->organization_id)->where('start_datetime', '>=', date("Y-m-d H:i"))->orderBy('start_datetime')->get();
        return view('admin.events.index', ['pageTitle' => 'Eventos', 'events' => $events]);
    }

    public function loadSingleEvent($eventSlug){

        $event = Event::where('slug', $eventSlug)->where('organization_id', Admin::find(Auth('admin')->user()->id)->organization_id)->get()->first();
        $tickets = $event->tickets;
        return view('admin.events.eventc', ['pageTitle' => 'Evento: '. $event->name, 'event' => $event, 'tickets' => $tickets, 'postUrl' => url('admin/event/update')]);
    }

    public function showNewEventTemplate(){
        $event = collect([
            (object) [
                'name' => '',
                'description' => '',
                'visible' => false,
                'slug' => '',
                'color' => '',
                'poster_url' => '',
                'start_datetime' => '',
                'end_datetime' => '',
                'max_capacity' => '',
                'venue_id' => '',
                'id' => '',
                'minimum_age' => '',
                'tags' => '',
                'venue' => [
                    'name' => '',
                    'currency' => '',
                    'timezone' => [
                        'madrid'
                    ],
                ],
                'tickets' => [
                    [
                        'name' => '',
                        'conditions' => '',
                        'slug' => '',

                    ]
                ]
                ]
        ]);
        $tickets = collect([
            [
                'slug' => ''
            ]
        ]);
    
        return view('admin.events.eventc', ['pageTitle' => 'Nuevo Evento', 'event' => $event->first, 'tickets' => $tickets, 'postUrl' => url('admin/event/new')]);
    }
}
