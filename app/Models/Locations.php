<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;

class Locations extends Vocabulary
{
    use HasFactory;

    public string|bool $sgln;
    public string|bool $name;
    public string|bool $address ;
    public string|bool $city  ;
    public string|bool $state ;
    public string|bool $postal_code;
    public string|bool $country_code;
    

    public function __construct(string|bool $sgln , string|bool $name , string|bool $address, string|bool $city, string|bool $state , string|bool $postal_code ,string|bool $country_code)
    {
        $this->sgln = $sgln;
        $this->name = $name;
        $this->address = $address;
        $this->city = $city;
        $this->state = $state;
        $this->postal_code = $postal_code;
        $this->country_code = $country_code;

    }
    public static function instance_location(array $params){



        return new Locations ($params["sgln"] ?? false,
                            $params["urn:epcglobal:cbv:mda#name"]?? false,
                            $params["urn:epcglobal:cbv:mda#streetAddressOne"]?? false,
                            $params["urn:epcglobal:cbv:mda#city"]?? false,
                            $params["urn:epcglobal:cbv:mda#state"]?? false,
                            $params["urn:epcglobal:cbv:mda#postalCode"]?? false,
                            $params["urn:epcglobal:cbv:mda#countryCode"]?? false);
                            
    }
    public function validate_sgln(){
        if(is_bool($this->sgln)){
            return "Campo sgln não existente";
        }
        // dd($this->sgln);
        if(trim($this->sgln) == ""){
            return "Campo sgln existente porém vazio";
        }
        $validate_sgln = Validator::make(['sgln' =>$this->sgln], [
            'sgln' => ['required', 'regex:/^urn:epc:id:sgln:[0-9]{4,12}(\.[0-9]{1,8}){2}$/'],
        ]);

        if($validate_sgln->fails() == true){
            return "SGLN invalido";
        }        
        
        return "Sgln OK";
    }
    public function validate_name(){
        if(is_bool($this->name)){
            return "Campo name não existente";
        }
        // dd($this->name);
        if(trim($this->name) == ""){
            return "Campo name existente porém vazio";
        }
        return "Name OK";
        
    }
    public function validate_address(){
        if(is_bool($this->address)){
            return "Campo address não existente";
        }
        // dd($this->address);
        if(trim($this->address) == ""){
            return "Campo address existente porém vazio";
        }
        return "Address OK";
        
    }
    public function validate_city(){
        if(is_bool($this->city)){
            return "Campo city não existente";
        }
        // dd($this->city);
        if(trim($this->city) == ""){
            return "Campo city existente porém vazio";
        }
        return "City OK";
        
    }
    public function validate_state(){
        if(is_bool($this->state)){
            return "Campo state não existente";
        }
        // dd($this->state);
        if(trim($this->state) == ""){
            return "Campo state existente porém vazio";
        }
        return "State OK";
        
    }
    public function validate_postal_code(){
        if(is_bool($this->postal_code)){
            return "Campo postal_code não existente";
        }
        // dd($this->postal_code);
        if(trim($this->postal_code) == ""){
            return "Campo postal_code existente porém vazio";
        }
        return "Postal Code OK";
        
    }
    public function validate_country_code(){
        if(is_bool($this->country_code)){
            return "Campo country_code não existente";
        }
        // dd($this->country_code);
        if(trim($this->country_code) == ""){
            return "Campo country_code existente porém vazio";
        }
        return "Country Code OK";
        
    }

    public function validate_fields_locations(){
        $results = [] ;
        $results[] = $this->validate_sgln();
        $results[] = $this->validate_name();
        $results[] = $this->validate_address();
        $results[] = $this->validate_city();
        $results[] = $this->validate_state();
        $results[] = $this->validate_postal_code();
        $results[] = $this->validate_country_code();
        return $results;
    }




}
