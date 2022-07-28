<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\User;
use App\Models\Following;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\DateController;
use App\Models\Event;
class NotificationsController extends Controller
{
    public function ShowNotifications(Request $request){
        if(Auth::guard('web')->guest()){
            return "No se permite ver notificaciones a los no registrados.";
        }
        $notifications = Notification::where('target_id', Auth::guard('web')->user()->id)
        ->orderBy('created_at', 'DESC')
        ->skip($request->limit)
        ->take(5)
        ->get();
        return view('components.notification-list', ['notifications' => $notifications]);
    }

    public function SearchNotifications(Request $request){
        if(Auth::guard('web')->guest()){
            return "No se permite ver notificaciones a los no registrados.";
        }
        $notifications = Notification::
        where('target_id', Auth::guard('web')->user()->id)
        ->where(fn($query) => $query->where('title', 'LIKE', '%'.$request->search_query.'%')
        ->orWhere('content', 'LIKE', '%'.$request->search_query.'%'))
        ->orderBy('created_at', 'DESC')
        ->limit(5)
        ->get();
        return view('components.notification-list', ['notifications' => $notifications]);
    }

    public function Share(Request $request){
        $validator = Validator::make($request->all(), [
            'target_type' => 'in:event_share,user_share,venue_share',
        ]);
        if($validator->fails()){
            $res['success'] = false;
            $res['message'] = 'Notificacion no enviada';
            return response()->json($res, 401);
        }
        switch ($request->target_type) {
            case 'event_share':
                $validator = Validator::make($request->all(), [ 'target_slug' => 'exists:events,slug' ]);
                if($validator->fails()){
                    $res['success'] = false;
                    $res['message'] = 'Notificacion no enviada';
                    return response()->json($res, 401);
                }
                foreach(json_decode($request->users_list_tags) as $user){
                    $user = User::where('email', $user->email)->get()->first();
                    if(!Following::where('follower_id', Auth::guard('web')->user()->id)->where('target_id', $user->id)->where('target_type', 'user')->get()->isEmpty()){
                        $event = Event::where('slug', $request->target_slug)->first();
                        Notification::create([
                            'target_id' => $user->id,
                            'origin_type' => 'user',
                            'origin_id' => Auth::guard('web')->user()->id,
                            'type' => 'event_share',
                            'title' => '<a href="#" class="text-indigo-500">'.Auth::guard('web')->user()->name.'</a> quiere que vayas a <a class="text-indigo-500 underline" href="'.url('venue/'.$event->venue->slug).'">#'.$event->venue->name.'</a>.',
                            'content' => '
                            <a class="text-indigo-500 underline" href="'.url('venue/'.$event->venue->slug).'">#'.$event->venue->name.'</a> 
                            tiene <a href="'.url('event/'.$event->slug).'" class="text-indigo-500 underline">'. $event->name. '</a> 
                            , el '.DateController::EventDates($event->start_datetime, $event->end_datetime).' y <a href="#" class="text-indigo-500">'.Auth::guard('web')->user()->name.'</a>  
                            lo ha compartido contigo. ¡No puedes fallar!',
                            'seen' => false,

                        ]);
                    }
                }
                break;
            
            default:
                # code...
                break;
        }    
        $res['success'] = true;
        $res['message'] = '<img class="w-5 h-5" src="'.asset('svg/1F918.svg').'">Acabas de notificar a tus amigos';
        return response()->json($res, 200);
    }


    public function ShowToast(Request $request){
        return view('components.toast-alert', ['message' => $request->message]);
    }
}
