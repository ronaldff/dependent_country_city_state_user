<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB;
use App\Models\{Country,State,City};

class UserController extends Controller
{

    public function index()
    {
        $users = DB::table('users')
        ->join('countries', 'countries.id', '=', 'users.country')
        ->join('states', 'states.id', '=', 'users.state')
        ->join('cities', 'cities.id', '=', 'users.city')
        ->select('users.name','users.id', 'users.email','countries.name as country_name', 'states.name as state_name', 'cities.name as city_name')
        ->get()
        ->toArray();

        return view('users')->with('users', $users);
    }

    public function edit(Request $request)
    {
        $user_id = $request->post('userid');
        $user = DB::table('users')
        ->where('users.id', $user_id)
        ->join('countries', 'countries.id', '=', 'users.country')
        ->join('states', 'states.id', '=', 'users.state')
        ->join('cities', 'cities.id', '=', 'users.city')
        ->select('users.name','users.id', 'users.email','countries.name as country_name','countries.id as country_id', 'states.name as state_name','states.id as state_id', 'cities.name as city_name', 'cities.id as city_id')
        ->get()
        ->toArray();
        $countries = Country::get(["name","id"]);
        $states = State::get(["name","id"]);
        $cities = City::get(["name","id"]);
        $output = EditResponse($user,$countries,$states,$cities);
        print_r($output);
        // $html = '<form>';

        // $html .= '<div class="form-group">
        //     <label for="name">Name</label>
        //     <input type="name" class="form-control" name="uname" id="name" placeholder="" value="'.$user[0]->name.'">
        // </div>';

        // // countries
        // $html .= '<div class="form-group">';
        //     $html .= '<label for="">Select Countries</label>';
        //     $html .= '<select class="form-control" id="country_dropdown">';
        //     foreach ($countries as $key => $country) {
        //         if($country['id'] == $user[0]->country_id){
        //             $html.= '<option selected value="'.$country['id'].'">'.$country['name'].'</option>';
        //         }else {
        //             $html.= '<option  value="'.$country['id'].'">'.$country['name'].'</option>';
        //         }
                
        //     }
        
        //     $html .= '</select>';
        // $html .= '</div>';


        // // states
        // $html .= '<div class="form-group">';
        //     $html .= '<label for="">Select States</label>';
        //     $html .= '<select class="form-control" id="state-dropdown" name="states">';
        //     foreach ($states as $key => $state) {
        //         if($state['id'] == $user[0]->state_id){
        //             $html.= '<option selected value="'.$state['id'].'">'.$state['name'].'</option>';
        //         }else {
        //             $html.= '<option  value="'.$state['id'].'">'.$state['name'].'</option>';
        //         }
                
        //     }
        //     $html .= '</select>';
        // $html .= '</div>';

        //  // cities
        // $html .= '<div class="form-group">';
        //     $html .= '<label for="">Select Cities</label>';
        //     $html .= '<select class="form-control" id="city-dropdown" name="cities">';
        //     foreach ($cities as $key => $city) {
        //         if($city['id'] == $user[0]->city_id){
        //             $html.= '<option selected value="'.$city['id'].'">'.$city['name'].'</option>';
        //         }else {
        //             $html.= '<option  value="'.$city['id'].'">'.$city['name'].'</option>';
        //         }
                
        //     }
            
        //     $html .= '</select>';
        // $html .= '</div>';
 

        // $html .= '<form>';
        // print_r($html);
    }


    public function getState(Request $request)
    {
        $data['states'] = State::where("country_id",$request->country_id)
                    ->get(["name","id"]);
        return response()->json($data);
    }

    public function getCity(Request $request)
    {
        $data['cities'] = City::where("state_id",$request->state_id)
                    ->get(["name","id"]);
        return response()->json($data);
    }
}
