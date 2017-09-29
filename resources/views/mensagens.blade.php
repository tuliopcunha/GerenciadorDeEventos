@extends('layouts.master')
@section('title', '')
@section('titlesection', '')
@section('descsection', '')
@section('principal')
@parent

<section class="content" align="center">
	<div class="row">
		<div class="col-lg-6">
			<br><br>
			<h3 align="center"><b><?php echo($mensagem); ?></b></h3>
			<br>
			<div align="center">
				<a href="{{ action('HomeController@index') }}"><button class="btn btn-primary">Inicio</button></a>
			</div>
		</div>
	</div>
</section>
@endsection