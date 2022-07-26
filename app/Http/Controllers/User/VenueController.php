<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VenueController extends Controller
{
    public function index(Request $request){
        $venues = Venue::where('visible', true)->get();
        return view('venues.index', ['pageTitle' => 'events']);
    }

    public function LocationBased(Request $request){
        if($request->has('lon') && $request->has('lat')){
            //Location based.
            $latitude = $request->lat;
            $longitude = $request->lon;
            $venues = Venue::where('visible', true)
            ->select('venues.*')
            ->selectRaw(
                'ST_Distance_Sphere(point(`longitude`, `latitude`), point(?, ?))/1000 AS distance',
                [$request->lon, $request->lat])
            ->orderByRaw('distance DESC')->get();
            return view('components.club-cards-container', ['venues' => $venues, 'title' => $request->title]);
        }
    }

    public function SearchVenue(Request $request){
        $results = Venue::
        where('visible', true)
        ->where('name', 'like', '%'.$request->search_query.'%')
        ->orWhere('description', 'like', '%'.$request->search_query.'%')
        ->orWhere('meta_data', 'like', '%'.$request->search_query.'%')
        ->orWhere('address', 'like', '%'.$request->search_query.'%')
        ->select('address as small', 'slug', 'name', 'logo_url as image_url', 'venues.*')
        ->limit('10')
        ->get();
        return view('components.search-venue-suggestions', ['results' => $results, 'url_prefix' => 'venue/']);
    }


    public function ShowSingleVenue($venue_slug){
        $venue = Venue::where('slug', $venue_slug)->where('visible', true)->first();
        if(!$venue){
            return view('404', ['pageTitle' => 'Error 404', 
            'message' => 'La discoteca que estás buscando no está disponible o no existe. Para que no pare la fiesta vuelve atrás y sigue buscando']);
        }
        return view('venues.venue', ['pageTitle' => $venue->name, 'venue'=> $venue]);
    }
}

        
/*function twopoints_on_earth($latitudeFrom, $longitudeFrom,
$latitudeTo,  $longitudeTo)
{
$long1 = deg2rad($longitudeFrom);
$long2 = deg2rad($longitudeTo);
$lat1 = deg2rad($latitudeFrom);
$lat2 = deg2rad($latitudeTo);

//Haversine Formula
$dlong = $long2 - $long1;
$dlati = $lat2 - $lat1;

$val = pow(sin($dlati/2),2)+cos($lat1)*cos($lat2)*pow(sin($dlong/2),2);

$res = 2 * asin(sqrt($val));

$radius = 3958.756;

return ($res*$radius);
}

// latitude and longitude of Two Points
$latitudeFrom = 19.017656 ;
$longitudeFrom = 72.856178;
$latitudeTo = 40.7127;
$longitudeTo = -74.0059;

// Distance between Mumbai and New York
print_r(twopoints_on_earth( $latitudeFrom, $longitudeFrom,
$latitudeTo,  $longitudeTo).' '.'miles');
*/