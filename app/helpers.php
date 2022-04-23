<?php

  function EditResponse($user,$countries,$states,$cities)
  {
    $html = '<form>';

        $html .= '<div class="form-group">
            <label for="name">Name</label>
            <input type="name" class="form-control" name="uname" id="name" placeholder="" value="'.$user[0]->name.'">
        </div>';

        // countries
        $html .= '<div class="form-group">';
            $html .= '<label for="">Select Countries</label>';
            $html .= '<select class="form-control" id="country_dropdown">';
            foreach ($countries as $key => $country) {
                if($country['id'] == $user[0]->country_id){
                    $html.= '<option selected value="'.$country['id'].'">'.$country['name'].'</option>';
                }else {
                    $html.= '<option  value="'.$country['id'].'">'.$country['name'].'</option>';
                }
                
            }
        
            $html .= '</select>';
        $html .= '</div>';


        // states
        $html .= '<div class="form-group">';
            $html .= '<label for="">Select States</label>';
            $html .= '<select class="form-control" id="state-dropdown" name="states">';
            foreach ($states as $key => $state) {
                if($state['id'] == $user[0]->state_id){
                    $html.= '<option selected value="'.$state['id'].'">'.$state['name'].'</option>';
                }else {
                    $html.= '<option  value="'.$state['id'].'">'.$state['name'].'</option>';
                }
                
            }
            $html .= '</select>';
        $html .= '</div>';

         // cities
        $html .= '<div class="form-group">';
            $html .= '<label for="">Select Cities</label>';
            $html .= '<select class="form-control" id="city-dropdown" name="cities">';
            foreach ($cities as $key => $city) {
                if($city['id'] == $user[0]->city_id){
                    $html.= '<option selected value="'.$city['id'].'">'.$city['name'].'</option>';
                }else {
                    $html.= '<option  value="'.$city['id'].'">'.$city['name'].'</option>';
                }
                
            }
            
            $html .= '</select>';
        $html .= '</div>';
 

        $html .= '<form>';
        return $html;
        // print_r($html);
  }

?>