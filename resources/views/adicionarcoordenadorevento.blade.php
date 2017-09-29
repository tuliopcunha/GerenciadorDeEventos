@extends('layouts.master')
@section('title', " - $meuEvento->eveNome")
@section('titlesection', 'Permissões')
@section('PaineldeControleAtivo','active')
@section('principal')
@parent
<div class="col-xs-10">
	<div class="box box-success">
		<div class="box-body">
			<form action="/eventos/{{$nomeEvento}}/{{$codigoEvento}}/adicionar_coordenador" method="POST">
				{!! csrf_field() !!}
				<div class="col-lg-6">
					<div class="box">
						<div class="box-body">
							<div class="form-group">
								<label>Selecione o usuário para conceder a permissão de coordenador</label>
								<select name="usuario" id="usuario" class="form-control">
									@foreach($usuarios as $row)
									<option value="{{ $row->id }}">{{ $row->name }} </option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					<div align="center">
						<button type="submit" name="OK" class="btn btn-primary">Adicionar</button>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="box">
						<div class="box-body">
							<label>Atuais Coordenadores do Evento</label>
							<ul>
								@foreach($coordenadores as $usuario)
								<li> {{$usuario->name}} </li>
								@endforeach
							</ul> 	
						</div>
					</div>
				</div>	
			</form>
		</div>
	</div>
</div>
@endsection


