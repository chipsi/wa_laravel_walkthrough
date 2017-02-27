@extends('layout')

@section('title', 'Vytvoreni osoby')

@section('content')
@if (count($errors) > 0)
<div class="alert alert-warning">
	<ul>
		@foreach ($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
	</ul>
</div>
@endif

@if (session('duplicate_err'))
<div class="alert alert-danger">
	V databazi uz takovyto zaznam je.
</div>
@endif

<form action="{{route('person::insert')}}" method="post">
	{{ csrf_field() }}

	<label>Jmeno</label>
	<input class="form-control" type="text" name="first_name" value="{{old('first_name')}}" />
	<br />

	<label>Prijmeni</label>
	<input class="form-control" type="text" name="last_name" value="{{old('last_name')}}" />
	<br />

	<label>Prezdivka</label>
	<input class="form-control" type="text" name="nickname" value="{{old('nickname')}}" />
	<br />

	<label>Adresa</label>
	<select class="form-control" name="id_location">
		<option value="">Nema</option>
		@foreach($locations as $loc)
		<option value="{{$loc->id}}" @if(old('id_location') == $loc->id) selected @endif>
				{{$loc->city}}, {{$loc->street_name}} {{$loc->street_number}}
		</option>
		@endforeach
</select>
<br />

<input type="submit" value="Pridat" class="btn btn-success" />
</form>
@endsection