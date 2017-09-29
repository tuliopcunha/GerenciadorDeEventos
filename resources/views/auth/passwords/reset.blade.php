@extends('layouts.register')
@section('title', 'Redefinição de Senha')
@section('titlesection', 'Redefinição de Senha')
@section('content')
<form class="form form--login" role="form" method="POST" action="{{ url('/password/reset') }}">
	{!! csrf_field() !!}

<input type="hidden" name="token" value="{{ $token }}">

	<div class="form__field">
		<label class="fontawesome-envelope-alt"><span class="hidden">Email</span></label>
		<input type="email" class="form__input" placeholder="Email" name="email" value="{{ $email }}" required autofocus>
	</div>


	@if ($errors->has('email'))
	<div class="form__field">
	<p>
		<span>
			<strong>{{ $errors->first('email') }}</strong>
		</span>
		</p>
	</div>
	@endif

	<div class="form__field">
		<label class="fontawesome-lock"><span class="hidden">Senha</span></label>
		<input type="password" id="password" class="form__input" onfocus="addBarra()" name="password" placeholder="Senha" minlength="8" maxlength="255" required>
	</div>
	<div class="center" id="barra">
	</div>


	@if ($errors->has('password'))
	<div class="form__field">
		<p>
		<span>
			<strong>{{ $errors->first('password') }}</strong>
		</span>
		</p>
	</div>
	@endif


	<div class="form__field">
		<label class="fontawesome-lock"><span class="hidden">Confirmar Senha</span></label>
		<input type="password" id="password_confirmation" class="form__input" oninput="checkPassword(this)" name="password_confirmation" placeholder="Confirmar Senha" minlength="8" required>
</div>
		@if ($errors->has('password_confirmation'))
		<div class="form__field">
		<p>
			<span>
				<strong>{{ $errors->first('password_confirmation') }}</strong>
			</span>
			</p>
		</div>
		
		@endif

		<div class="form__field">
			<input type="submit" name="login" value="Resetar">
		</div>
	</form>
	@endsection
