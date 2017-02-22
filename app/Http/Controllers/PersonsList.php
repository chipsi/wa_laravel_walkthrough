<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\Location;

class PersonsList extends Controller
{

	function show() {
		$persons = Person::orderBy('last_name')->get();
		return view('persons/list', [
			'persons' => $persons
		]);
	}

}
