@extends('layouts.auth')
@section('title','Esqueci Meu Email')
@section('content')

<p class="text--center" style="font-size:20px;">
	@if ($email) 
	Seu email é <b>{{ $email }}</b>.
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