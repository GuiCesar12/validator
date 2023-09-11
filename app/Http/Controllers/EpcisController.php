<?php

namespace App\Http\Controllers;

use App\Models\Body;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Epcis;
use App\Models\EventList;
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
        $result = [];
        
        $masterData = $xmlString->EPCISHeader->extension->EPCISMasterData;
        $vocabulary = new Vocabulary;

        $result [] = ["Header"=>["Vocabulary"=>$vocabulary->validate_vocabularys($masterData)]];
        $event_list = new EventList;
        $result[]= ["Body"=>["EventList"=>$event_list->validate($xmlString->EPCISBody->EventList)]];
        dd($result);
        // dd($vocabulary->validate_vocabularys($masterData));
        
   


    }
    
    





}
