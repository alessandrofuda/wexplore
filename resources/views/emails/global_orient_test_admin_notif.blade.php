@extends('emails.templates.layout1')



@section('content')

	<div class="body">
		[-- wexplore Admin notification --]<br/><br/>
		Hello Admins,<br/>
		<br/>
		a new user has completed the <b>Global Orientation Test</b><br/>
		<br/>
		<br/>
		<br/>
		Name: {{ $user->name }}<br/>
		Surname: {{ $user->surname }}<br/>
		E-mail: {{ $user->email }}<br/>
		<br/>
		<br/>
		<a href="{{ url('login') }}">Wexplore</a>
		<br/>
	</div>

@endsection