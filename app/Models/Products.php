<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;

class Products extends Vocabulary
{
    use HasFactory;

    public string|bool $sgtin;
    public string|bool $ndc;
    public string|bool $type_code ;
    public string|bool $product_type  ;
    public string|bool $form_type ;
    public string|bool $content_description;
    

    public function __construct(string|bool $sgtin , string|bool $ndc , string|bool $type_code, string|bool $product_type, string|bool $form_type , string|bool $content_description)
    {
        $this->sgtin = $sgtin;
        $this->ndc = $ndc;
        $this->type_code = $type_code;
        $this->product_type = $product_type;
        $this->form_type = $form_type;
        $this->content_description = $content_description;

    }
    public static function instance_product(array $params){



        return new Products ($params["sgtin"] ?? false,
                            $params["urn:epcglobal:cbv:mda#additionalTradeItemIdentification"]?? false,
                            $params["urn:epcglobal:cbv:mda#additionalTradeItemIdentificationTypeCode"]?? false,
                            $params["urn:epcglobal:cbv:mda#regulatedProductName"]?? false,
                            $params["urn:epcglobal:cbv:mda#dosageFormType"]?? false,
                            $params["urn:epcglobal:cbv:mda#netContentDescription"]?? false);
                            
    }
    public function validate_sgtin(){
        if(is_bool($this->sgtin)){
            return "Campo sgtin não existente";
        }
        // dd($this->sgtin);
        if(trim($this->sgtin) == ""){
            return "Campo sgtin existente porém vazio";
        }
        $validate_sgtin = Validator::make(['sgtin' =>$this->sgtin], [
            'sgtin' => ['required', 'regex:/^urn:epc:id:sgtin:[0-9]{4,12}\.[0-9]{1,10}\.[0-9A-Za-z]{1,30}$/'],
        ]);

        if($validate_sgtin->fails() == true){
            return "Sgtin invalido";
        }        
        return "Sgin Ok";
        
    }

    public function validate_ndc(){
        if(is_bool($this->ndc)){
            return "Campo ndc não existente";
        }
        
        // dd($this->ndc);
        if(trim($this->ndc) == ""){
            return "Campo ndc existente porém vazio";
        }
        // dd($this->ndc);
        $validate_ndc = Validator::make(['ndc' =>$this->ndc], [
            'ndc' => ['required', 'regex:/^\d{5}-?\d{4}-?\d{2}$/'],
        ]);

        if($validate_ndc->fails() == true){
            return "NDC invalido";
        }        
        return "Ndc OK";
        
    }

    
    public function validate_type_code(){
        if(is_bool($this->type_code)){
            return "Campo type_code não existente";
        }
        
        if(trim($this->type_code) == ""){
            return "Campo type_code existente porém vazio";
        } 
        return "Type Code OK";
        
    }

    public function validate_product_type(){
        if(is_bool($this->product_type)){
            return "Campo product_type não existente";
        }

        if(trim($this->product_type) == ""){
            return "Campo product_type existente porém vazio";
        }
        return "Product type OK";
        
    }


    public function validate_form_type(){
        if(is_bool($this->form_type)){
            return "Campo form_type não existente";
        }

        if(trim($this->form_type) == ""){
            return "Campo form_type existente porém vazio";
        }  
        return "Form Type OK";
        
    }


    public function validate_content_description(){
        if(is_bool($this->content_description)){
            return "Campo content_description não existente";
        }
        // dd($this->content_description);
        if(trim($this->content_description) == ""){
            return "Campo content_description existente porém vazio";
        }        
        return "Content Description OK";
        
    }
    public function validate_fields(){
        $results = [];
        $results[] = $this->validate_sgtin();
        $results[] = $this->validate_ndc();
        $results[] = $this->validate_type_code();
        $results[]= $this->validate_product_type();
        $results[]= $this->validate_form_type();
        $results[]= $this->validate_content_description();
        return $results;
    }

}
