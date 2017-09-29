@extends('layouts.master')
@section('title', ' - Inscrição de Eventos Exclusivos')
@section('titlesection', 'Inscrição de Eventos Exclusivos')
@section('eventosAtivo', 'active')
@section('css')
@parent
<link rel="stylesheet" href="{{ asset('data/plugins/fullcalendar/fullcalendar.min.css') }}">
<link rel="stylesheet" href="{{ asset('data/plugins/fullcalendar/fullcalendar.print.css') }}" media="print">
@endsection
@section('principal')
@parent
    <div class="row">
    <section class="invoice">
      <div class="page-header" >
          Escolha a Atividade que Você deseja se inscrever: <br>
      </div>
      <div class="row">
    @foreach($atividadesDoPacoteEvento as $ati) 
<form action="/Inscreve" method="post">
  {!! csrf_field() !!}
  <input type="hidden" name="Codigo" value="{{ $ati->atiCod }}">
   <div class="col-md-3">
   <?php 
            $QuantidadeVagas = DB::table('inscricao')
                      ->where('ins_atiCod',$ati->atiCod)->count();
        ?>    
    @if($QuantidadeVagas >= $ati->atiNumVagas)
        <div class="box box-danger box-solid">
        @else
        <div class="box box-success box-solid">
        @endif 
      
        <?php

        $dataI = substr($ati->atiDataIniInsc, 0, 10);
        $dataF = substr($ati->atiDataFimInsc, 0, 10);
        $dataIn = date('d-m-Y',strtotime($dataI));
        $dataFi = date('d-m-Y',strtotime($dataF));
        ?>
        
        <div class="box-header with-border">
          <h3 class="box-tittle text-center">{{ $ati->atiNome }}</h3>    
        </div>
        <div class="box-body box-profile">  
        
        <strong><i class="fa fa-user margin-r-5"></i> Vagas : &nbsp;</strong> {{$QuantidadeVagas}}/{{$ati->atiNumVagas}}
        <br><br>
        <strong><i class="fa fa-shopping-cart margin-r-5"></i> Conteudo : &nbsp;</strong> {{$ati->atiConteudo}}
        <br><br>
        <strong><i class="fa fa-clock-o margin-r-5"></i> Carga Horaria : &nbsp;</strong> {{$ati->atiCargaHoraria}}
        <br><br>

        @if(($ati->atiPreco <> 0)||($ati->atiPreco <> NULL))
        <strong><i class="fa fa-dollar margin-r-5"></i> Preço : &nbsp;</strong> R$ {{$ati->atiPreco}}
        <br><br>
        @endif
        <strong><i class="fa fa-lock margin-r-5"></i> Pré-Requisitos : &nbsp;</strong> {{$ati->atiPreRequisito}}


        <hr>

        @if($inscrito==1)
        <center><button type="submit" class="btn btn-primary bg-" name="Participar"> Inscreva-se</button></center>
        @elseif($inscrito==2)
        <center><button type="submit" class="btn btn-primary" name="Cancelar"> Cancelar Inscrição</button></center>
        @endif

      </div>
      <!-- /.box-body -->
    </div>
    </div>
    </form>
    @endforeach
    </div>
    </section></div>
    <!-- /.col -->
    

    @endsection

    @section('js')
    @parent
    <script type="text/javascript" src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('data/plugins/fullcalendar/fullcalendar.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('data/plugins/fullcalendar/lang/pt-br.js') }}"></script>
    @endsection