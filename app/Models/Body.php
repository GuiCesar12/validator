<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Body extends Epcis
{
    use HasFactory;

    public function validate_body($params){
        return new EventList($params->EventList);

    }
}
