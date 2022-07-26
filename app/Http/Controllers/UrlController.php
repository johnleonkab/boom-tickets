<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UrlController extends Controller
{
    
    public static function slugGenerate($string, $tableName){
        $truncated = Str::limit(Str::slug($string, '_'), 16, "");
        $uuid = Str::limit(Str::uuid() ,8, "");
        $slug = $truncated."_".$uuid;
        function slugAlreadyExists($slug, $table){
            $results = DB::table($table)->where('slug', $slug)->count();
            if($results == 0){
                return false;
            }
            return true;
        }
        while(slugAlreadyExists($slug, $tableName)){      
            $slug = $truncated."_".Str::limit(Str::uuid() ,8, "");
        }
        return $slug;
    }
}
