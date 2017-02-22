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

	function delete(Request $r, $id) {
		if(!empty($id)) {
			$p = Person::find($id);
			if($p) {
				$p->delete();
			}
		}
		return redirect(route('person::list'));
	}

	function create() {
		$locations = Location::orderBy('city')->get();
		return view('persons/create', [
			'locations' => $locations
		]);
	}

	function insert(Request $r) {
		if($r->has('nickname') && $r->has('first_name') && $r->has('last_name')) {
			$p = new Person();
			$p->nickname = $r->get('nickname');
			$p->first_name = $r->get('first_name');
			$p->last_name = $r->get('last_name');
			$p->id_location = $r->get('id_location');
			$p->save();
		}
		return redirect(route('person::list'));
	}

}
