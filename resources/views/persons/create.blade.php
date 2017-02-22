<!DOCTYPE html>
<html>
	<head>
		<title>Osoby</title>
		<meta charset="utf-8" />
	</head>
	<body>
		<nav>
			<a href="{{route('person::list')}}">Vypis osob</a>
			<a href="{{route('person::create')}}">Nova osoba</a>
		</nav>

		<hr />

		<form action="{{route('person::insert')}}" method="post">
			{{ csrf_field() }}

			<label>Jmeno</label>
			<input type="text" name="first_name" />
			<br />

			<label>Prijmeni</label>
			<input type="text" name="last_name" />
			<br />

			<label>Prezdivka</label>
			<input type="text" name="nickname" />
			<br />

			<label>Adresa</label>
			<select name="id_location">
				<option value="">Nema</option>
				@foreach($locations as $loc)
				<option value="{{$loc->id}}">{{$loc->city}}, {{$loc->street_name}} {{$loc->street_number}}</option>
				@endforeach
			</select>
			<br />

			<input type="submit" value="Pridat" />
		</form>
	</body>
</html>