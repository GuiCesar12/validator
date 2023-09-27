<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LDAP\Result;
use Illuminate\Support\Facades\Validator;

class AggregationEvent extends EventList
{
    use HasFactory;

    public string $event_time ;
    public string|bool $event_time_zone_offset ;
    public string|bool $parent_id ;
    public array $childEPCs;
    public string|bool $action ;
    public string|bool $biz_step ;
    public string|bool $disposition ;
    public array $read_point ;
    public array $biz_location ;





    public function __construct(string $event_time ,
                                string|bool $event_time_zone_offset ,
                                string|bool $parent_id ,
                                array $childEPCs,
                                string|bool $action ,
                                string|bool $biz_step ,
                                string|bool $disposition ,
                                array|bool $read_point ,
                                array|bool $biz_location 
                                 )
    {
        $this->event_time = $event_time ;
        $this->event_time_zone_offset = $event_time_zone_offset ;
        $this->parent_id = $parent_id ;
        $this->childEPCs = $childEPCs;
        $this->action = $action ;
        $this->biz_step = $biz_step ;
        $this->disposition = $disposition ;
        $this->read_point = $read_point;
        $this->biz_location = $biz_location;

    }

    public static function instance_aggregation_events($params){
        return new AggregationEvent($params["eventTime"]??false,
                              $params["eventTimeZoneOffset"]??false, 
                              $params["parentID"]??false,
                              $params["childEPCs"]??[],
                              $params["action"]??false, 
                              $params["bizStep"]??false, 
                              $params["disposition"]??false, 
                              $params["readPoint"]??[], 
                              $params["bizLocation"]??[]
        );
    }

    public function validate_event_time(){

        if(is_bool($this->event_time)){
            return "Campo event_time não existente";
        }

        if(trim($this->event_time) == ""){
            return "Campo event_time existente porém vazio";
        }
        return "event_time OK";
    }
    public function validate_event_time_zone_offset(){
        if(is_bool($this->event_time_zone_offset)){
            return "Campo event_time_zone_offset não existente";
        }

        if(trim($this->event_time_zone_offset) == ""){
            return "Campo event_time_zone_offset existente porém vazio";
        }        
        return "event_time_zone_offset OK";
    }
    public function validate_childEPCs(){
        $valid = is_array($this->childEPCs["epc"]) ? $this->childEPCs["epc"] : [$this->childEPCs["epc"]];
            foreach($valid as $list){
                $validate_sgtin = Validator::make(['sgtin' =>$list], [
                    'sgtin' => ['required', 'regex:/^urn:epc:id:sgtin:[0-9]{4,12}\.[0-9]{1,10}\.[0-9A-Za-z]{1,30}$/'],
                ]);
        
                if($validate_sgtin->fails() == true){
                    return "Sgtin invalido";
                }        
                
                if(is_bool($list)){
                    return "Campo childEPCs não existente";
                }
                
                if(trim($list) == ""){
                    return "Campo childEPCs existente porém vazio";
                }        
    
            
            }
        return "childEPCs OK";

    }

    public function validate_action(){
        if(is_bool($this->action)){
            return "Campo action não existente";
        }
        
        if(trim($this->action) == ""){
            return "Campo action existente porém vazio";
        }        
        return "action OK";
    }
    public function validate_biz_step(){
        if(is_bool($this->biz_step)){
            return "Campo biz_step não existente";
        }
        

        
        if(trim($this->biz_step) == ""){
            return "Campo biz_step existente porém vazio";
        }        
        return "biz_step OK";
    }
    public function validate_disposition(){
        if(is_bool($this->disposition)){
            return "Campo disposition não existente";
        }
        
   
        
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
        $results[] = $this->validate_childEPCs();
        $results[] = $this->validate_action();
        $results[] = $this->validate_biz_step();
        $results[] = $this->validate_disposition();
        $results[] = $this->validate_read_point();
        $results[] = $this->validate_biz_location();
        return $results;
    }

}
