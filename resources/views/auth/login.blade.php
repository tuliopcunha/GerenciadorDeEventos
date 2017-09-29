@extends('layouts.auth')
@section('title', 'Login')
@section('titlesection', 'Faça o login')
@section('content')

<form class="form form--login" role="form" method="POST" action="{{ url('/login') }}">
	{{ csrf_field() }}

	<div class="form__field">
		<label class="fontawesome-user" for="login__username"><span class="hidden">Email</span></label>
		<input type="email" class="form__input" placeholder="Email" name="email" value="{{ old('email') }}" required autofocus>
	</div>

	<div class="form__field">
		<label class="fontawesome-lock" for="login__password"><span class="hidden">Senha</span></label>
		<input type="password" class="form__input" placeholder="Senha" name="password" minlength="8" required>
	</div>

	<div class="left">
		&nbsp;&nbsp;<a class="btn btn-link" href="{{ url('/esquecimeuemail') }}">Esqueceu seu email?</a> 
		<a class="btn btn-link" href="{{ url('/password/reset') }}">Esqueceu sua senha?</a><br> 
	</div>
	@if (!$errors->isEmpty())
	<div class="center"><p>
		<strong>Email e/ou senha incorretos</strong>
		@if ($errors->has('g-recaptcha-response'))
		<br><strong>O captcha é obrigatório:</strong>
		</p>
		@endif
	</div>
	@endif
	@if (session('errorlogin'))
	{!! app('captcha')->display(); !!}
	<br>		
	@endif

	<div class="form__field">
		<input type="submit" name="login" value="Login">
	</div>

	<p class="text--center">Não é um membro?<a href="{{ url('/register') }}">Cadastre-se </a>&nbsp;<span class="fontawesome-arrow-right"></span></p>
</form>
@endsection