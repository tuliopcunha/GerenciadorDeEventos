@extends('layouts.master')
@section('principalAtivo','active')
@section('principal')
@parent
<section>
	<div class="col-md-12">
		<a href="{{ url('/eventos/II%20Jornada%20de%20Arte%20e%20Cultura/2') }}"><img src="{{ asset('data/banner.jpg') }}" class="img-responsive img-rounded"></a>
	</div>
</section>       
@endsection