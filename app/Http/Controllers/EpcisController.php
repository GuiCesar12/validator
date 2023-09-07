<?php

namespace App\Http\Controllers;

use App\Models\Body;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Epcis;
use App\Models\Header;
use App\Models\Locations;
use App\Models\Products;
use App\Models\Vocabulary;


class EpcisController extends Controller
{
    public function verify(Request $request){
        $xmlString = file_get_contents($request->file()['epcis']->getPathName());
        $xmlString = simplexml_load_string($xmlString);
        $version = $xmlString->attributes()->schemaVersion;
        //verifica a versão do Schema que precisa ser 1.2
        if(Epcis::verifySchemaVersion($version) == true){
        }        
        else{
            echo "Versão fora do padrão 1.2 de 2016";
        }
        $masterData = $xmlString->EPCISHeader->extension->EPCISMasterData;
        $vocabulary = new Vocabulary;
        $vocabulary->validate_vocabularys($masterData);
        $body =  new Body;
        $body->validate_body($xmlString->EPCISBody);
        // dd($vocabulary->validate_vocabularys($masterData));
        
   


    }
    
    





}
