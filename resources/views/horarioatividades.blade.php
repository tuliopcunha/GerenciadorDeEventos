@extends('layouts.master')
@section('titlesection', 'Defina os horários da sua atividade')
@section('atividadesAtivo','active')
@section('principal')
@parent
<b><h4><font color="red"> {{ $mensagem }} </font></h4></b>
<div>

	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#Cadastro" aria-controls="Cadastro" role="tab" data-toggle="tab">Cursos</a></li>
		<li role="presentation"><a href="#horarios" aria-controls="horr" role="tab" data-toggle="tab">Horários ({{ $val->atiNome }})</a></li>
	</ul>
	<!-- Tab panes -->
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="Cadastro">
			<div>
				<h4> <b> A atividade {{ $val->atiNome }} terá uma carga horária de {{ $val->atiCargaHoraria }} horas. </b></h4>
				<h4> <b> Já foram cadastradas {{ $total }} horas. </b></h4><br>
				@if($total<=$val->atiCargaHoraria)
				<div class="col-lg-4">
					<form action="/atividades/cadastro_horarios" method="post">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">   
						<input type="hidden" name="Codigo" value="{{ $val->atiCod }}">   
						<h4><b> Cadastre o restante dos horários</b> </h4>

						<h5><b>Escolha o dia</b></h5> 
						<input type="date" name="data" class="form-control"></input> <br> <br>


						<h5><b>Defina o horário da atividade na data escolhida</b></h5>



						De: <select name="Inicio" class="form-control">
						@for($i=7;$i<=22;$i++)
						<option >{{ $i }}:00</option>
						@endfor
					</select>
					Até: <select name="Fim" class="form-control">
					@for($i=7;$i<=22;$i++)
					<option>{{ $i }}:00</option>
					@endfor
				</select>
				<button type="submit" class="btn btn-primary">Cadastrar Horario</button>
			</form>

		</div>
		@endif
	</div>
</div>
<div role="tabpanel" class="tab-pane" id="horr">

	<fieldset>

		<center><legend>Quadro de Hórarios da Atividade</legend></center>
		<table border="1" class="table table-striped">
			<thead>
				<tr>
					<th>Atividade</th>
					<th>Data</th>
					<th>Horário de Inicio</th>
					<th>Horário de Termino</th>
				</tr>
			</thead>
			<tbody>


				<?php
				$hor = session('horario'); 
				?>
				@foreach($hor as $horario)
				@if($horario->hor_atiCod==$val->atiCod)
				<?php 
				$horaInicio=$horario->horDataIniRealizacao;
				$horaIni = substr($horaInicio, 11, 8); 
				$horaFim = $horario->horDataFimRealizacao;
				$horaF= substr($horaFim, 11, 8); 
				?>
				<tr>
					<td>{{ $val->atiNome }}</td>
					<td><?php 
						$data = substr($horario->horDataIniRealizacao, 0, 10); 
						setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
						date_default_timezone_set('America/Sao_Paulo');
						echo strftime('%A, %d de %B de %Y', strtotime($data));
						?></td>
						<td>{{ $horaIni }}</td>
						<td>{{ $horaF }}</td>
					</tr>
					@endif

					@endforeach

				</tbody>
			</table>

		</fieldset>



	</div>
</div>
</div>




@endsection