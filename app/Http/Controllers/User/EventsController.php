<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Following;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EventsController extends Controller
{

    public function index(){
        return view('events.index', ['pageTitle' => 'Eventos']);
    }

    public function SearchEvent(Request $request){
        $timezone = "Europe/Madrid";
        $query = Event::with(['venue', 'organization'])
        ->where('visible', 1)
        ->where('start_datetime', '>=', Carbon::now()->tz($timezone)->format('Y-m-d H:i:s'))
        ->Where(fn($query) => $query->where('name', 'LIKE', '%'.$request->search_query.'%')
            ->orWhere('description', 'LIKE', '%'.$request->search_query.'%')
            ->orWhere('tags', 'LIKE', '%'.$request->search_query.'%')
            ->orWhere('start_datetime', 'LIKE', '%'.$request->search_query.'%'))
        ->orWhere(fn($q) => $q->whereHas('venue', fn($query) => $query->where('visible', true)->where('name', 'LIKE', '%'.$request->search_query.'%')
            ->orWhere('meta_data', 'LIKE', '%'.$request->search_query.'%')))
        ->orWhere(fn($q) => $q->whereHas('organization', fn($query) => $query->where('visible', true)->where('name', 'LIKE', '%'.$request->search_query.'%')))
        ->limit(5);
        $results = $query->count();
        $events = $query->get();
        if($results != 0){
            return view('components.search-event-suggestions', ['events' => $events]);
        }
        $stringArray = explode(' ', $request->search_query);
        $query = Event::with('venue')->where('visible', 1)->where('start_datetime', '>=', Carbon::now()->tz($timezone)->format('Y-m-d H:i:s'))
        ->where(function ($q) use ($stringArray) {
            foreach ($stringArray as $value) {
                 $q->orWhere('name', 'like', "%{$value}%");
                 $q->orWhere('description', 'like', "%{$value}%")
                 ->orWhere(fn($q) => $q->whereHas('venue', fn($query) => $query->where('visible', true)
                 ->Where('name', 'LIKE', '%'.$value.'%')->orwhere('meta_data', 'LIKE', '%'.$value.'%')));
            } 
        })->limit(5);
        $results = $query->count();
        $events = $query->get();
        if($results != 0){
            return view('components.search-event-suggestions', ['events' => $events]);
        }
        return "No hay más resultados";

    }

    public static function SoonEvents(){
        $timezone = "Europe/Madrid";
        $events = Event::where('visible', true)->where('start_datetime', '>=', Carbon::now()->tz($timezone)->format('Y-m-d H:i:s'))->limit(25)->get();
        return view('components.events-slider', ['events' => $events]);
    }

    public static function FollowingEvents(){
        $timezone = "Europe/Madrid";
        $followedEvents = Following::select('target_id')->where('target_type', 'event')
        ->where('follower_id', Auth::guard('web')->user()->id)->get();

        $events = Event::whereIn('id', $followedEvents)->get();
        
        return view('components.events-slider', ['events' => $events]);
    }

    public static function CloseEvents(){
        $timezone = "Europe/Madrid";
        $events = Event::where('visible', true)->where('start_datetime', '>=', Carbon::now()->tz($timezone)->format('Y-m-d H:i:s'))->limit(25)->get();
        return view('components.events-slider', ['events' => $events]);
    }


    public function ShowSingleEvent($event_slug){
        $event = Event::where('slug', $event_slug)->first();
        if(!$event){
            return back()->with('error', 'No se ha podido encontrar el evento.');   
        }
        if(!$event->visible){
            return back()->with('error', 'El evento que buscas no está disponible.');    
        }
        return view('events.event', ['pageTitle' => $event->name, 'event' => $event]);
    
    }

    public function Isndex(){
        $latitude = 37.37914349034231;
$longitude = -5.9719303577862775;

$geocodeFromLatLong = file_get_contents('http://dev.virtualearth.net/REST/v1/Locations/'.$latitude.','.$longitude.'?key=Ak-e3GTfx7JM5oyj1KivDG1Xl3wvbUMVG-Zj_RkHAsKDItanxguBZHfLQwwlDVwA'); 
$output = json_decode($geocodeFromLatLong);

return $output->resourceSets[0]->resources[0]->address->adminDistrict.", ".$output->resourceSets[0]->resources[0]->address->adminDistrict2;
    }
}
