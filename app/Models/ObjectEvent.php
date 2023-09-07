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
    public array|bool $read_point ;
    public array|bool $biz_location ;
    public array|bool $extension ;





    public function __construct(string|bool $event_time ,
                                string|bool $event_time_zone_offset ,
                                array $epc_list ,
                                string|bool $action ,
                                string|bool $biz_step ,
                                string|bool $disposition ,
                                array|bool $read_point ,
                                array|bool $biz_location ,
                                array|bool $extension 
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

    }

    public static function instance_objects_events($params){
        return new ObjectEvent($params["eventTime"]??false,
                              $params["eventTimeZoneOffset"]??false, 
                              $params["epcList"]??[], 
                              $params["action"]??false, 
                              $params["bizStep"]??false, 
                              $params["disposition"]??false, 
                              $params["readPoint"]??false, 
                              $params["bizLocation"]??false, 
                              $params["extension"]??false, 
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

    public function validate_fields(){
        $results = [];
        $results[] = $this->validate_epc_list();
        return $results;
    }





}
