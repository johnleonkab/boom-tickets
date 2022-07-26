<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Carbon\Carbon;
class DateController extends Controller
{
    public static function GetDate($date, $format){
        \Carbon\Carbon::setLocale('es');
        switch ($format) {
            case 'semicomplete':
                if(Carbon::now()->format('Y') == Carbon::parse($date)->format('Y')){
                    $dateString = Carbon::parse($date)->translatedFormat('d \d\e F H:i');
                    return $dateString;
                }
                $dateString = Carbon::parse($date)->translatedFormat('d \d\e m \d\e Y');
                return $dateString;
                break;
            case 'interval':
                if(Carbon::now()->format('Y') == Carbon::parse($date['start'])->format('Y')){
                    $dateString = Carbon::parse($date['start'])->translatedFormat('d \d\e F H:i')." - ".Carbon::parse($date['end'])->translatedFormat('H:i \d\e\l d \d\e F');
                    return $dateString;
                }
                $dateString = Carbon::parse($date['start'])->translatedFormat('d \d\e F H:i')." - ".Carbon::parse($date['end'])->translatedFormat('H:i \d\e\l d \d\e F');
                return $dateString;
                break;
            case 'shortYmd':
                return Carbon::parse($date)->format('Y/m/d H:i');
                break;
            default:
                # code...
                break;
        }       
    }

    public static function EventDates($start_date, $end_date){
        $timezone = 'Europe/Madrid';
        $start_date_local = Carbon::parse($start_date)->timezone($timezone);
        $end_date_local = Carbon::parse($end_date)->timezone($timezone);
        $now = Carbon::now();
        $sameYear = Carbon::parse($now)->format('Y') == Carbon::parse($start_date_local)->format('Y');
        if($sameYear){
            if($start_date_local->diffInHours($end_date_local) < 24){
                return Carbon::parse($start_date_local)->format('d/m H:i'). ' <span class="align-middle material-symbols-outlined">
                arrow_forward
                </span> '.Carbon::parse($end_date_local)->format('H:i');
            }else{
                return Carbon::parse($start_date_local)->format('d/m H:i'). ' <span class="align-middle material-symbols-outlined">
                arrow_forward
                </span> '.Carbon::parse($end_date_local)->format('d/m H:i');
            }
        }else{
            if($start_date_local->diffInHours($end_date_local) < 24){
                return Carbon::parse($start_date_local)->format('d/m/y H:i'). ' <span class="align-middle material-symbols-outlined">
                arrow_forward
                </span> '.Carbon::parse($end_date_local)->format('H:i');
            }else{
                return Carbon::parse($start_date_local)->format('d/m/Y H:i'). ' <span class="align-middle material-symbols-outlined">
                arrow_forward
                </span> '.Carbon::parse($end_date_local)->format('d/m/Y H:i');
            }
        }
    }
}
