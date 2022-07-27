<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Following;
use App\Models\Venue;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Auth;

class FollowerController extends Controller
{

    public function Follow(Request $request){
        if( Auth::guard('web')->guest()){
            return back();
        }
        $validator = Validator::make($request->all(), [
            'target_type' => 'in:venue,event,user',
            'target_slug' => 'exists:'.$request->target_type.'s,slug'
        ]);
        if($validator->fails()){
            return back()->with('error', 'Ha habido un error.');
        }
        switch ($request->target_type) {
            case 'venue':
                $venue = Venue::where('slug', $request->target_slug)->get();
                if($venue->isEmpty()){  return back()->with('error', 'Ha habido un error.'); }
                $newFollow = Following::updateOrCreate([
                    'follower_id' => Auth::guard('web')->user()->id,
                    'target_type' => 'venue',
                    'target_id' => $venue->first()->id
                ], []);
                return view('livewire.unfollow-button', ['target_type' => 'venue', 'target_slug' => $request->target_slug]);
                break;
            case 'event':
                $event = Event::where('slug', $request->target_slug)->get();
                if($event->isEmpty()){  return back()->with('error', 'Ha habido un error. No se ha encontrado el evento que quieres seguir'); }
                $newFollow = Following::updateOrCreate([
                    'follower_id' => Auth::guard('web')->user()->id,
                    'target_type' => 'event',
                    'target_id' => $event->first()->id
                ], []);
                return view('livewire.unfollow-button', ['target_type' => 'event', 'target_slug' => $request->target_slug]);
                break;
                case 'user':
                    $user = User::where('username', $request->target_slug)->get();
                if($user->isEmpty()){  return back()->with('error', 'Ha habido un error. No se ha encontrado el usuario que quieres seguir'); }
                $newFollow = Following::updateOrCreate([
                    'follower_id' => Auth::guard('web')->user()->id,
                    'target_type' => 'event',
                    'target_id' => $user->first()->id
                ], []);
                return view('livewire.unfollow-button', ['target_type' => 'user', 'target_slug' => $request->target_slug]);
                break;
            default:
            return back();
                break;
        }
    }
    public function UnFollow(Request $request){
        if( Auth::guard('web')->guest()){
            return back();
        }
        $validator = Validator::make($request->all(), [
            'target_type' => 'in:venue,event,user',
            'target_slug' => 'exists:'.$request->target_type.'s,slug'
        ]);
        if($validator->fails()){
            return back()->with('error', 'Ha habido un error.');
        }
        switch ($request->target_type) {
            case 'venue':
                $venue = Venue::where('slug', $request->target_slug)->get();
                if($venue->isEmpty()){  return back()->with('error', 'Ha habido un error. No se ha encontrado la disocteca que quieres dejar de seguir'); }
                $deleteFollow = Following::where('follower_id', Auth::guard('web')->user()->id)
                   ->where('target_type', 'venue')
                   ->where('target_id', $venue->first()->id)
                   ->delete();
                   return view('livewire.follow-button', ['target_type' => 'venue', 'target_slug' => $request->target_slug]);
                break;
            case 'event':
                $event = Event::where('slug', $request->target_slug)->get();
                if($event->isEmpty()){  return back()->with('error', 'Ha habido un error. No se ha encontrado el evento que quieres seguir'); }
                $deleteFollow = Following::where('follower_id', Auth::guard('web')->user()->id)
                   ->where('target_type', 'event')
                   ->where('target_id', $event->first()->id)
                   ->delete();
                return view('livewire.follow-button', ['target_type' => 'event', 'target_slug' => $request->target_slug]);
                break;
                case 'user':
                    $user = User::where('username', $request->target_slug)->get();
                if($user->isEmpty()){  return back()->with('error', 'Ha habido un error. No se ha encontrado el usuario que quieres seguir'); }
                $deleteFollow = Following::where('follower_id', Auth::guard('web')->user()->id)
                   ->where('target_type', 'user')
                   ->where('target_id', $user->first()->id)
                   ->delete();
                return view('livewire.follow-button', ['target_type' => 'user', 'target_slug' => $request->target_slug]);
                break;
            default:
            return back();
                break;
        }
    }
}
