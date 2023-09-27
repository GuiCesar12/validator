<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Header
{
    use HasFactory;

    public static function get_timestamp($xml){
        $data = $xml->attributes()->creationDate;
        $array = json_encode($data);
        $array = json_decode($array,true);
        return $array[0];
    }
}
