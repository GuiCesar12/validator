<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AggregationEvent;
use App\Models\ObjectEvent;
use Illuminate\Support\Collection;
class EventList extends Body
{
    use HasFactory;

    public function validate($params)
    {
        $types = $this->get_type_object_events($params);
        $result = [];
        $result [] = $this->validate_object_events($types);
        return $result;
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
