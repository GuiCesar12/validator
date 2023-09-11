<?php

namespace App\Models;

use Hamcrest\Arrays\IsArray;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObjectEvent extends EventList
{
    use HasFactory;

    public string|bool $event_time ;
    public string|bool $event_time_zone_offset ;
    public array $epc_list ;
    public string|bool $action ;
    public string|bool $biz_step ;
    public string|bool $disposition ;
    public array $read_point ;
    public array $biz_location ;
    public array $extension ;
    public array $destination_list;





    public function __construct(string|bool $event_time ,
                                string|bool $event_time_zone_offset ,
                                array $epc_list ,
                                string|bool $action ,
                                string|bool $biz_step ,
                                string|bool $disposition ,
                                array|bool $read_point ,
                                array|bool $biz_location ,
                                array|bool $extension,
                                array $destination_list
                                 )
    {
        $this->event_time = $event_time ;
        $this->event_time_zone_offset = $event_time_zone_offset ;
        $this->epc_list = $epc_list ;
        $this->action = $action ;
        $this->biz_step = $biz_step ;
        $this->disposition = $disposition ;
        $this->read_point = $read_point;
        $this->biz_location = $biz_location;
        $this->extension = $extension;
        $this->destination_list = $destination_list;

    }

    public static function instance_objects_events($params){
        return new ObjectEvent($params["eventTime"]??false,
                              $params["eventTimeZoneOffset"]??false, 
                              $params["epcList"]??[], 
                              $params["action"]??false, 
                              $params["bizStep"]??false, 
                              $params["disposition"]??false, 
                              $params["readPoint"]??[], 
                              $params["bizLocation"]??[], 
                              $params["extension"]??[], 
                              $params["destinationList"]??[]
        );
    }

    public function validate_event_time(){
        if(is_bool($this->event_time)){
            return "Campo event_time não existente";
        }
        
        // dd($this->event_time);
        if(trim($this->event_time) == ""){
            return "Campo event_time existente porém vazio";
        }
        return "event_time OK";
    }
    public function validate_event_time_zone_offset(){
        if(is_bool($this->event_time_zone_offset)){
            return "Campo event_time_zone_offset não existente";
        }
        
        // dd($this->event_time_zone_offset);
        if(trim($this->event_time_zone_offset) == ""){
            return "Campo event_time_zone_offset existente porém vazio";
        }        
        return "event_time_zone_offset OK";
    }
    public function validate_epc_list(){
        $valid = is_array($this->epc_list["epc"]) ? $this->epc_list["epc"] : [$this->epc_list["epc"]];
            foreach($valid as $list){
                
                if(is_bool($list)){
                    return "Campo epc_list não existente";
                }
                
                if(trim($list) == ""){
                    return "Campo epc_list existente porém vazio";
                }        
    
            
            }
        return "epc_list OK";

    }

    public function validate_action(){
        if(is_bool($this->action)){
            return "Campo action não existente";
        }
        
        // dd($this->action);
        if(trim($this->action) == ""){
            return "Campo action existente porém vazio";
        }        
        return "action OK";
    }
    public function validate_biz_step(){
        if(is_bool($this->biz_step)){
            return "Campo biz_step não existente";
        }
        
        // dd($this->biz_step);
        if(trim($this->biz_step) == ""){
            return "Campo biz_step existente porém vazio";
        }        
        return "biz_step OK";
    }
    public function validate_disposition(){
        if(is_bool($this->disposition)){
            return "Campo disposition não existente";
        }
        
        // dd($this->disposition);
        if(trim($this->disposition) == ""){
            return "Campo disposition existente porém vazio";
        }        
        return "disposition OK";
    }
    
    public function validate_read_point(){
        $valid = is_array($this->read_point["id"]) ? $this->read_point["id"] : [$this->read_point["id"]];
            foreach($valid as $list){
                
                if(is_bool($list)){
                    return "Campo read_point não existente";
                }
                
                if(trim($list) == ""){
                    return "Campo read_point existente porém vazio";
                }        
    
            
            }
        return "read_point OK";

    }
    
    public function validate_extension(){
        if(isset($this->extension["ilmd"])){
            $valid = is_array($this->extension["ilmd"]) ? $this->extension["ilmd"] : [$this->extension["ilmd"]];
            foreach($valid as $list){
                if(is_bool($list)){
                    return "Campo extension não existente";
                }
                if(trim($list) == ""){
                    return "Campo extension existente porém vazio";
                }        
            }
        }else{
            return "Campo extension não existe";
        }
        return "extension OK";
    }
    



    public function validate_biz_location(){
       
        $valid = is_array($this->biz_location["id"]) ? $this->biz_location["id"] : [$this->biz_location["id"]];
            foreach($valid as $list){
                
                if(is_bool($list)){
                    return "Campo biz_location não existente";
                }
                
                if(trim($list) == ""){
                    return "Campo biz_location existente porém vazio";
                }        
    
            
            }
        return "biz_location OK";

    }




    public function validate_fields(){
        $results = [];
        $results[] = $this->validate_event_time();
        $results[] = $this->validate_event_time_zone_offset();
        $results[] = $this->validate_epc_list();
        $results[] = $this->validate_action();
        $results[] = $this->validate_biz_step();
        $results[] = $this->validate_disposition();
        $results[] = $this->validate_read_point();
        $results[] = $this->validate_biz_location();
        $results[] = $this->validate_extension();
        return $results;
    }


    public function validate_extension_secondary(){
        if(isset($this->extension["sourceList"]["source"]) && isset($this->extension["destinationList"]["destination"])){
            $source = $this->extension["sourceList"]["source"];
            $destination = $this->extension["destinationList"]["destination"];

            // dd([$source,$destination]);

            $valid_source = is_array($source) ? $source : [$source];
            $valid_destination = is_array($destination) ? $destination : [$destination];

            foreach($valid_source as $list_source){
                if(is_bool($list_source)){
                    return "Campo extension não existente";
                }
                if(trim($list_source) == ""){
                    return "Campo extension existente porém vazio";
                }        
            }
            foreach($valid_destination as $list){
                if(is_bool($list)){
                    return "Campo extension não existente";
                }
                if(trim($list) == ""){
                    return "Campo extension existente porém vazio";
                }        
            }
        }else{
            return "Campo extension não existe";
        }
        return "extension OK";
    }













    public function validate_fields_secondary(){
        $results = [];
        $results[] = $this->validate_event_time();
        $results[] = $this->validate_event_time_zone_offset();
        $results[] = $this->validate_epc_list();
        $results[] = $this->validate_action();
        $results[] = $this->validate_biz_step();
        $results[] = $this->validate_disposition();
        $results[] = $this->validate_read_point();
        $results[] = $this->validate_extension_secondary();
        return $results;
    }



}
