@extends('layouts.register')
@section('title', 'Cadastro')
@section('titlesection', 'Cadastre-se')
@section('content')
<form class="form form--login" role="form" method="POST" action="{{ url('/register') }}">
	{!! csrf_field() !!}

	<div class="form__field">
		<label class="fontawesome-user"><span class="hidden">Nome</span></label>
		<input type="text" class="form__input" name="name" placeholder="Nome" value="{{ old('name') }}" minlength="3" maxlength="50" required autofocus>
	</div>

	@if ($errors->has('name'))
	<script>
		document.getElementById('name').setCustomValidity('{{ $errors->first("name") }}');
	</script>
	<div class="form__field">
	<p>
		<span>
			<strong>{{ $errors->first('name') }}</strong>
		</span>
		</p>
	</div>

	@endif

	<div class="form__field">
		<label class="fontawesome-envelope-alt"><span class="hidden">Email</span></label>
		<input type="email" id="email" class="form__input" name="email" placeholder="Email" minlength="7" maxlength="255" value="{{ old('email') }}" required>
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
		<label class="fontawesome-list-alt"><span class="hidden">CPF</span></label>
		<input type="text" id="usuCpf" class="form__input" name="usuCpf" placeholder="CPF" size="14" minlength="14" maxlength="14" value="{{ old('usuCpf') }}" required>
	</div>

	@if ($errors->has('usuCpf'))
	<div class="form__field">
	<p>
		<span>
			<strong>Este CPF já está cadastrado</strong>
		</span>
		</p>
	</div>
	@endif
	
	<div class="form__field">
		<label class="fontawesome-lock"><span class="hidden">Senha</span></label>
		<input type="password" id="password" class="form__input" onfocus="addBarra()" name="password" placeholder="Senha" minlength="6" maxlength="255" required>
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
		<label class="fontawesome-lock"><span class="hidden">Confirme a Senha</span></label>
		<input type="password" class="form__input" name="password_confirmation" placeholder="Confirme a Senha" minlength="8" maxlength="255" oninput="checkPassword(this)" required>
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

	@if (session('errorregister'))
	@if ($errors->has('g-recaptcha-response'))
	<div class="center">
	<p>
		<strong>O captcha é obrigatório:</strong>
	</p>
	</div>
	@endif
	{!! app('captcha')->display(); !!}      
	<br>
	@endif

	<div class="form__field">

		<input type="submit" name="cadastrar" value="Cadastrar">
	</div>

	<p class="text--center">Já é um membro?<a href="{{ url('/login') }}">Faça Login </a>&nbsp;<span class="fontawesome-arrow-right"></span></p>
</form>
</div>

@endsection
