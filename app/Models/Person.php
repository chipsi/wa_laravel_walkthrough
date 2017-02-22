<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{

	protected $table = "persons";

    public function location()
    {
        return $this->belongsTo('App\Models\Location', 'id_location');
    }

}
