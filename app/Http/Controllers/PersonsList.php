<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function redirect;
use function route;
use function view;

class PersonsList extends Controller
{

	private $formRules = [
		'nickname' => 'required|max:100',
		'first_name' => 'required|max:100',
		'last_name' => 'required|max:100',
		'id_location' => 'integer|nullable|exists:locations,id'
	];

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
		$this->validate($r, $this->formRules);

		try {
			$p = new Person();
			$p->nickname = $r->get('nickname');
			$p->first_name = $r->get('first_name');
			$p->last_name = $r->get('last_name');
			$p->id_location = $r->get('id_location');
			$p->save();
		} catch(\Exception $e) {
			return redirect(route('person::create'))->withInput($r->all)->with('duplicate_err', true);
		}

		return redirect(route('person::list'));
	}

}
