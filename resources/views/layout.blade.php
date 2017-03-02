<!DOCTYPE html>
<html>
    <head>
		<meta charset="utf-8" />
        <title>Sprava osob - @yield('title')</title>
		<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
		<link rel="stylesheet" href="{{asset('css/app.css')}}">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </head>
    <body>
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
						<span class="sr-only">Zobrazit navigaci</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="{{route('person::list')}}">Sprava osob</a>
				</div>

				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li>
							<a href="{{route('person::list')}}">Vypis osob</a>
						</li>
						<li>
							<a href="{{route('person::create')}}">Nova osoba</a>
						</li>
					</ul>

					@if (Auth::guest())
					<ul class="nav navbar-nav navbar-right">
						<li><a href="{{ route('login') }}">Login</a></li>
						<li><a href="{{ route('register') }}">Register</a></li>
					</ul>
					@else
						<form action="{{ route('logout') }}" method="post" class="navbar-form navbar-right">
							{{ csrf_field() }}
							<input class="btn btn-default" type="submit" value="Logout {{ Auth::user()->name }}" />
						</form>
					@endif
				</div>
			</div>
		</nav>

        <div class="container">
            @yield('content')
        </div>
    </body>
</html>