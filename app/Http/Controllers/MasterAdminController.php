<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;
use App\Models\Admin;
use App\Models\Venue;
use Illuminate\Support\Facades\Validator;


class MasterAdminController extends Controller
{
    public function Authorization($authorization_code_1, $authorization_code_2){
        return true; 
    }
    public function CreateUpdateOrganization(Request $request){
        if(!$this->Authorization(1,3)){
            return response('No puedes hacer cambios', 405);
        }
        
        $validator = Validator::make($request->all(),
        [
            'name' => 'required',
            'description' => 'required',
            'logo_url' => 'required',
        ]);

        if($validator->fails()){
            return "Error de validación, vuelve a intentarlo";
        }

        //Create Stripe user:
        $stripe = new \Stripe\StripeClient(env('STRIPE_API_KEY'));
        $account = $stripe->accounts->create(['type' => 'express']);
        $slug = "or_".UrlController::slugGenerate($request->name, 'organizations');
        if(isset($request->slug)){
            $slug = $request->slug;
        }
            
        $organization = Organization::updateOrCreate(
            ['slug' => $slug],
            [
                'stripe_user_id' => $account->id,
                'name' => $request->name,
                'description' => $request->description,
                'logo_url' => $request->logo_url,
                'contact_information' => '',
                'meta_data' => '',
                'rating' => '',
                'visible' => true,
            ]
            );
            return "Organización creada con éxito";
    }

    public function CreateUpdateAdmin(Request $request){
        
    }

    public function CreateUpdateVenue(Request $request){
        if(!$this->Authorization(1,3)){
            return response('No puedes hacer cambios', 405);
        }
        
        $validator = Validator::make($request->all(),
        [
            'name' => 'required',
            'description' => 'required',
            'logo_url' => 'required',
            'timezone' => 'required',
            'organization_id' => 'required|exists:organizations,id',
        ]);

        if($validator->fails()){
            return $validator->errors();
        }

        $slug = "ve_".UrlController::slugGenerate($request->name, 'organizations');
        if(isset($request->slug)){
            $slug = $request->slug;
        }
            
        $organization = Venue::updateOrCreate(
            ['slug' => $slug],
            [
                'name' => $request->name,
                'description' => $request->description,
                'logo_url' => $request->logo_url,
                'latitude' => $request->lat,
                'longitude' => $request->lon,
                'currency' => $request->currency,
                'timezone' => $request->timezone,
                'organization_id' => $request->organization_id,
                'rating' => '',
                'meta_data' => '',
            ]
            );
            return "Organización creada con éxito";
    }

}
