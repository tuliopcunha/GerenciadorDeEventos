@extends('layouts.auth')
@section('title', 'Redefinição de Senha')
@section('titlesection', 'Redefinição de Senha')
@section('content')

<form class="form form--login" role="form" method="POST" action="{{ url('/password/email') }}">
	{!! csrf_field() !!}
	<div class="center">
		<p>Insira seu endereço de email cadastrado para obter um link de redefinição de senha:</p>
	</div>

	<div class="form__field">
		<label class="fontawesome-envelope-alt"><span class="hidden">Email</span></label>
		<input type="email" class="form__input" placeholder="Email" name="email" value="{{ old('email') }}" required autofocus>
	</div>

	<div class="center">
		@if (session('status'))
		<p><b>
			{{ session('status') }}
		</b></p>
		@endif	

		@if ($errors->has('email'))
		<p>
		<strong>{{ $errors->first('email') }}</strong>
		</p>
		@endif
	</div>

	<div class="form__field">
		<input type="submit" name="login" value="Enviar Email">
	</div>
	<p class="text--center">Sabe sua senha ?<a href="{{ url('/login') }}">Faça Login </a>&nbsp;<span class="fontawesome-arrow-right"></span></p>
	@endsection

