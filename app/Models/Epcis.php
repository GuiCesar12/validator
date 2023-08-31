<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Epcis extends Model
{
    use HasFactory;


    public static function verifySchemaVersion($params){
        if($params == 1.2){
            return true;
        }else{
            return false;
        }
    }


}
