<!DOCTYPE html>
<html>
	<head>
		<title>Osoby</title>
		<meta charset="utf-8" />
	</head>
	<body>
		<table>
			<tr>
				<th>Jméno</th>
				<th>Adresa</th>
			</tr>
			@foreach($persons as $person)
			<tr>
				<td>{{$person->first_name}} {{$person->last_name}}</td>
				@if($person->location)
				<td>{{$person->location->city}}, {{$person->location->street_name}} {{$person->location->street_number}}</td>
				@else
				<td>Nema adresu</td>
				@endif
			</tr>
			@endforeach
		</table>
	</body>
</html>