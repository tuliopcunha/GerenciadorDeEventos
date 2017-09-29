@extends('layouts.register')
@section('title','Esqueci Meu Email')
@section('titlesection', 'Digite seu CPF')
@section('content')

<form class="form form--login" id="esquecimeuemail" role="form" method="POST" action="{{ url('/esquecimeuemail') }}">
	{!! csrf_field() !!}
	<div class="form__field">
		<label class="fontawesome-list-alt"><span class="hidden">CPF</span></label>
		<input type="text" id="usuCpf" class="form__input" name="cpf" placeholder="CPF" size="14" minlength="14" maxlength="14" value="{{ old('cpf') }}" oninput="this.setCustomValidity('')" required>
	</div>



	<form class="form form--login" role="form">
		<div class="form__field">
			<input type="submit" id="submit" value="Confirmar"> 
		</div>
	</form>
@if ($errors->has('cpf'))
	<script>
		document.getElementById('usuCpf').setCustomValidity('CPF não cadastrado');
		if(!document.getElementById('esquecimeuemail').checkValidity()){
		document.getElementById('submit').click();
	}
	</script>
	@endif
	<script type="text/javascript" src="{!! asset('data/plugins/jQuery/jQuery-2.1.4.min.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('data/js/maskRegister.js') !!}"></script>
	@endsection