@extends('layouts.auth')
@section('title','Cadastro')
@section('titlesection', 'Email Enviado')
@section('content')

<p class="text--center">
	@if (session('email')) 
	Um email foi enviado para {{ session('email') }}. 
	Acesse seu email e clique no link de confirmação para continuar seu cadastro!
	@endif
	@if (isset($email)) 
	Você não confirmou seu cadastro.
	Um email foi enviado para {{ $email }}. 
	Acesse seu email e clique no link de confirmação para confirmar seu cadastro!
	@endif
</p>

<form class="form form--login" role="form">
	<a href="{{ url('/login') }}">
		<div class="form__field">
			<input type="button" value="Voltar">
		</div>
	</a>
</form>
@endsection