<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HumanFormatter extends Controller
{
    public static function Number($number){
        if($number > 1000000000){
            $number = $number/1000000000;
            $number = round($number, 1)."mill.";
            return $number;
        }
        if($number > 1000){
            $number = $number/1000;
            $number = round($number, 1)."k.";
            return $number;
        }
        return $number;
    }
}
