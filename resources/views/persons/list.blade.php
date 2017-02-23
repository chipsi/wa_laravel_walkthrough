@extends('layout')

@section('title', 'Vypis osob')

@section('content')
@if (session('successful_insert'))
<div class="alert alert-success alert-dismissible">
	Osoba byla uspesne vlozena.
	<button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
@endif

<table class="table table-striped">
	<tr>
		<th>Jméno</th>
		<th>Adresa</th>
		<th>Smazat</th>
	</tr>
	@foreach($persons as $person)
	<tr>
		<td>{{$person->first_name}} {{$person->last_name}}</td>
		@if($person->location)
		<td>{{$person->location->city}}, {{$person->location->street_name}} {{$person->location->street_number}}</td>
		@else
		<td>Nema adresu</td>
		@endif
		<td>
			<form action="{{route('person::delete', ['id' => $person->id])}}" method="post" onsubmit="return confirm('Opravdu smazat?')">
				{{ csrf_field() }}
				<input type="submit" value="Smazat" class="btn btn-danger" />
			</form>
		</td>
	</tr>
	@endforeach
</table>
@endsection