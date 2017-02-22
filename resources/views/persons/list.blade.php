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

		<table>
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
						<input type="submit" value="Smazat" />
					</form>
				</td>
			</tr>
			@endforeach
		</table>
	</body>
</html>