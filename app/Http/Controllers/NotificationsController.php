<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

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
        $notifications = Notification::where('target_id', Auth::guard('web')->user()->id)
        ->where('title', 'LIKE', '%'.$request->search_query.'%')
        ->orWhere('content', 'LIKE', '%'.$request->search_query.'%')
        ->orderBy('created_at', 'DESC')
        ->limit(5)
        ->get();
        return view('components.notification-list', ['notifications' => $notifications]);
    }
}
