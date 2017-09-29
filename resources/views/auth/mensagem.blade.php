@extends('layouts.auth')
@section('title','Erro')
@section('titlesection', 'Erro')
@section('content')

<p class="text--center">
	@if (isset($mensagem)) 
	{{ $mensagem }}
	@endif
</p>

<form class="form form--login" role="form">
		<div class="form__field">
			<input type="button" value="Voltar" onclick="history.go(-1);"> 
		</div>
</form>
@endsection