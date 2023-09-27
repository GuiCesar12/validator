<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AggregationEvent;
use App\Models\ObjectEvent;
use Carbon\Carbon;
use Illuminate\Support\Collection;
class EventList extends Body
{
    use HasFactory;

    public function validate($params)
    {
        $result = [];
        $aggregation = $this->get_aggregation_to_array($params);
        $types = $this->get_type_object_events($params);
        $result [] = $this->validate_object_events($types);
        $result[]=$this->validate_aggregation_events($aggregation);
        return $result;
    }
    private function get_all_event_times($params){
        $datas = $this->get_aggregation_to_array($params);
        
        $obj_event_time = [];
        foreach($datas as $data){
            $obj_event_time []=    $data["eventTime"];
        }
        return $obj_event_time;
    }
    public function validate_timestamp($event_list, $timestamp){
        $event_times = $this->get_all_event_times($event_list);
        $timestamp = Carbon::parse($timestamp);
        $timestamp_converted = $timestamp->format('Y-m-d H:i:s');
        $dates_event = [];
        foreach($event_times as $events){
            $dates_event[] = Carbon::parse($events);
        }
        $result_dates_events = [];
        foreach($dates_event as $dates_events){
            $result_dates_events []= $dates_events->format('Y-m-d H:i:s');
        }
        
        foreach($result_dates_events as $results){
            $results_carbon = Carbon::parse($results);
            
            if($results_carbon->isAfter($timestamp_converted) == true){
                return response('Event time de algum evento está invalido' ,400);
            }
        }
        return true;

    
    }

    private function get_aggregation_to_array($params){
        $agreggation_event = $params->AggregationEvent;
        $datas = [];
        foreach($agreggation_event as $data){
            $json = json_encode($data);
            $array = json_decode($json,true);
            $datas[] = ((array)$array);
        }
        return $datas;
    }


    private function validate_aggregation_events($params){

        $datas = [];
        foreach($params as $data){
            $datas[] = AggregationEvent::instance_aggregation_events($data)->validate_fields();
        }
        return ["AggregationEvent"=>$datas];
        
    }







    private function get_object_events_to_array($params){
        $datas = [];
        foreach($params->ObjectEvent as $data){
            $json = json_encode($data);
            $array = json_decode($json,true);
            $datas[] = ((array)$array);
            // $datas = ObjectEvent::instance_object($array);
        }
        return $datas;
    }

    private function get_type_object_events($params){
        $objects = $this->get_object_events_to_array($params);
        $datas = collect($objects);
        $first = [];
        $secondary = [];
        foreach($objects as $data){
            if($datas->last() == $data){
                $secondary[] = $data;
            }else{
                $first[]= $data;
            }
        }
        return ["ObjectsEvents"=>$first,"ObjectsEventsAggregation"=>$secondary];
    }
    private function validate_object_events($types){
        $datas = [];
        $result = [];
        $obj_aggregation = [];
        // dd($types["ObjectsEvents"]);
        foreach($types["ObjectsEvents"] as $first){
            $datas[]  = ObjectEvent::instance_objects_events($first)->validate_fields();
        }
        foreach($types["ObjectsEventsAggregation"] as $secondary){
            // dd($secondary);
            $obj_aggregation[] = ObjectEvent::instance_objects_events($secondary)->validate_fields_secondary();
        }
        
        return ["ObjectsEvents"=>$datas,"ObjectsEventsAggregation"=>$obj_aggregation];
    }


}   
