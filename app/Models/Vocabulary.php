<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products;
use App\Models\Locations;

class Vocabulary extends Header
{
    use HasFactory;

    public function validate_vocabularys($params){
        return $this->instance_types($params);
        
    }


    private function get_vocabulary_type($params){
        
        $vocabulary = [];
        foreach($params->VocabularyList->Vocabulary as $data){
            $type = $data->attributes()->type;
            $vocabulary[] = $type[0];
            
            
        }
        return $vocabulary;

    }

    protected function instance_types($params){
        // dd($params);
        $types = $this->get_vocabulary_type($params);
       
            
            if (in_array("urn:epcglobal:epcis:vtype:EPCClass",$types)){
                $products_validated = $this->validate_products($params);
                
            }
            if(in_array("urn:epcglobal:epcis:vtype:Location",$types)){

                $location_validated = $this->validate_locations($params);
            
            }
            $result = [];
            $result[] = $products_validated;
            $result[] = $location_validated;
            return $result;
        
    }

    private function validate_locations($params){
        $datas = [];
        $count = 1;
        foreach($params->VocabularyList->Vocabulary[1]->VocabularyElementList->VocabularyElement as $key=>$data){
        
            $children = $this->get_children_elements($data->children());
            if(trim($data->attributes()->id)){
                
                $children['sgln'] = trim(((array)$data->attributes()->id)[0]);
            }
            $new_key = $children['sgln']?? $count;
            $datas [$new_key] = Locations::instance_location($children)->validate_fields_locations() ;
            $count += 1;
        }
        return $datas;


    }









    private function validate_products($params){
        $datas = [];
        $count = 1;
        foreach($params->VocabularyList->Vocabulary[0]->VocabularyElementList->VocabularyElement as $key=>$data){
        
            $children = $this->get_children_elements($data->children());
            if(trim($data->attributes()->id)){
                
                $children['sgtin'] = trim(((array)$data->attributes()->id)[0]);
            }
            
            $new_key = $children['sgtin']?? $count;
            $datas [$new_key] = Products::instance_product($children)->validate_fields() ;
            $count += 1;
        }
        return $datas;
    }



    protected function get_children_elements($children_){
        $childrens = [];
        foreach($children_ as $children){
        //    $childrens [$children->attributes()] =  $children ;
        

            $childrens [((array)$children->attributes()->id)[0]] = ((array)$children[0])[0]; 
        }
        return $childrens;
    }



    
        
    







}
