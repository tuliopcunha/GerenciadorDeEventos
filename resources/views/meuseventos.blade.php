@extends('layouts.master')
@section('title', ' - Meus Eventos')
@section('titlesection', 'Meus Eventos')
@section('eventosAtivo', 'active')
@section('principal')
@parent
<div class="row">

  <div class="col-md-6 col-xs-12 col-sm-12 col-lg-6 ">
    <div class="tab-content box box-success">
      <div class="tab-pane active box-body " id="home">
       @if(sizeof($eventos) == 0)
       <center><h2> Atualmente você não está Inscrito em nenhum evento!</h2></center>
       @endif 
       @foreach($eventos as $eve)                   
       <div class="small-box bg-primary">
        <div class="inner">
          <h4>{{ $eve->eveNome }}</h4>
        </div>

        <input type="hidden" name="Codigo" value="{{ $eve->eveCod }}"></input>
        <center>
          <p>
            Inscrições : <b>Início:</b> {{ date('d-m-y', strtotime($eve->eveDataIniInsc)) }} 
            &nbsp;&nbsp;
            <b>Fim:</b> {{date('d-m-y', strtotime($eve->eveDataFimInsc))}}
          </p>
        </center>
        <a href="/eventos/{{$eve->eveNome}}/{{$eve->eveCod}}" class="small-box-footer">
          Ir Para Página do Evento <i class="fa fa-arrow-circle-right"></i>
        </a>
      </div>
      
      @endforeach

    </div>
  </div>
</div>

@endsection