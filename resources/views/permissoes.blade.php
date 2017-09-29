@extends('layouts.master')
@section('titlesection', 'Permissões')
@section('PaineldeControleAtivo','active')
@section('principal')
@parent
<form action="/permissoes/confirma_dados" method="post">
	{!! csrf_field() !!}
	<div class="col-lg-4">
		<div class="form-group">
			<label>Selecione o usuário para conceder a permissão</label>
			<select name="NomeUsuario" class="form-control">
				@foreach($usuarios as $row)
				<option value="{{ $row->id }}">{{ $row->name }} </option>
				@endforeach
			</select>
		</div>
		<div align="center">
			<button type="submit" name="OK" class="btn btn-primary">Confirmar</button>
		</div>
	</div>    
</form>
@endsection


