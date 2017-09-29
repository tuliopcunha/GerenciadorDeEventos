@extends('layouts.master')
@section('titlesection', 'Atividade')
@section('atividadesAtivo','active')
@section('principal')
@parent

<link rel="stylesheet" href="{{ asset('plugins/fullcalendar/fullcalendar.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/fullcalendar/fullcalendar.print.css') }}" media="print">
<div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Informações Básicas</a></li>
    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Informações de Localização</a></li>
    <li role="presentation" class="active"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Lista de Presença</a></li>
    <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Quadro de Horários</a></li>
  </ul>
  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane" id="home">
      <fieldset>
        <center><legend> <h1>Dados da Atividade</h1>
        </legend></center>
        <div class="col-lg-6">
          <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" value="{{ $dados->atiNome }}" class="form-control" placeholder="Nome" disabled>
          </div>
          <div class="form-group">
            <label for="Conteudo">Conteúdo</label>
            <input type="text" id="Email" name="conteudo" value="{{ $dados->atiConteudo }}" class="form-control" placeholder="Conteudo da Atividade"disabled>
          </div>
          <div class="form-group">
            <label for="Pré-Requisitos">Pré-Requisitos</label>
            <input type="text" id="CPF" name="prequisitos" value="{{ $dados->atiPreRequisitos }}" class="form-control" placeholder="Pré-Requisitos" disabled >
          </div>
          <div class="form-group">
            <label for="Pré-Requisitos">Tipo de Atividade</label>
            @if($dados->ati_tipAtiCod==2)
            <input type="text" id="CPF" name="prequisitos" value="Curso" class="form-control" placeholder="Pré-Requisitos" disabled >
            @elseif($dados->ati_tipAtiCod==3)
            <input type="text" id="CPF" name="prequisitos" value="Palestra" class="form-control" placeholder="Pré-Requisitos" disabled >
            @endif
            
          </div>

        </div>
        <div class="col-lg-6">
          <div class="form-group">
            <label for="Preço">Preço</label>
            <input type="text" id="RG" name="Preco" class="form-control"  value="{{ $dados->atiPreco }}" placeholder="Preço" disabled >
          </div>
          <div class="form-group">
            <label for="Material">Necessidade de Material ou Ambiente</label>
            <input type="text" id="RG" name="ambiente" class="form-control"  value="{{ $dados->atiNecessidadeMaterialAmbiente }}" placeholder="Necessidade de Material ou Ambiente"disabled  >
          </div>
          <div class="form-group">
            <label for="Material">Carga Horária</label>
            <input type="text" id="RG" name="horario" class="form-control"  value="{{ $dados->atiCargaHoraria }}" placeholder="Carga Horária" disabled >
          </div>
          <form method="post" action="/atividades/minhas_atividades/informacoes/alterainformacoes">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" value="{{ $dados->atiCod }}"  name="Cod"></input>
            <button class="btn btn-primary" name="Altear">Alterar Informações</button>
          </form>
          
        </div>
      </div>
    </fieldset>

    <div role="tabpanel" class="tab-pane" id="profile">
      <fieldset>

        <center><legend>Endereço</legend></center>
        <div class="col-lg-6">

          <div class="form-group">
            <label for="Rua">Logradouro</label>
            <input type="text" id="Rua" name="Rua" value="<?php 
            echo $ende->endRua?>" class="form-control" placeholder="Rua/Avenida/Alameda" >
          </div>
          <div class="form-group">
            <label for="Numero">Número</label>
            <input type="text" id="numero" name="numero" value="<?php echo $ende->endNumero?>" class="form-control" placeholder="Numero"disabled>
          </div>
          <div class="form-group">
            <label for="Bairro">Bairro</label>
            <input type="text" id="Bairro" name="Bairro" class="form-control" value="<?php echo $ende->endBairro ?>"placeholder="Bairro" >
          </div>
          <div class="form-group">
            <label for="Complemento">Complemento</label>
            <input type="text" id="Complemento" name="Complemento" class="form-control" value="<?php echo $ende->endComplemento?>" placeholder="Pais" >
          </div>
          <div class="form-group">
            <label for="comment">Informações Adicionais</label>
            <textarea class="form-control" rows="5" name="adicional" placeholder="Informações Adicionais" disabled>{{ $ende->endInfAdicionais }}</textarea>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="form-group">
            <label for="Cidade">Cidade</label>
            <input type="text" id="Cidade" name="Cidade" class="form-control" value="<?php echo $ende->endCidade?>" placeholder="Cidade" >
          </div>
          <div class="form-group">
            <label for="CEP">CEP</label>
            <input type="text" id="CEP" name="CEP" class="form-control" value="<?php echo $ende->endCEP?>" placeholder="CEP" >
          </div>
          <div class="form-group">
            <label for="Estado">Estado</label>
            <input type="text" id="Estado" name="Estado" class="form-control" value="<?php echo $ende->endEstado?>" placeholder="Estado" >
          </div> 
          <div class="form-group">
            <label for="Pais">País</label>
            <input type="text" id="Pais" name="Pais" class="form-control" value="<?php echo $ende->endPais?>" placeholder="Pais" >
          </div>
        </div>
      </fieldset>


    </div>
    <div role="tabpanel" class="tab-pane active" id="messages">
      <?php

      $dataI = substr($dados->atiDataIniInsc, 0, 10);
      $dataF = substr($dados->atiDataFimInsc, 0, 10);
      $dataIn = date('d-m-Y',strtotime($dataI));
      $dataFi = date('d-m-Y',strtotime($dataF));
      $data=date('Y-m-d H:i:s');; 
      ?>
      <fieldset>
        <form action="/pdf" method="post">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <center><legend>Lista de presença para impressão(.pdf)</legend></center> <br>
          <div class="form-group">

           <input type="hidden" value="{{ $dados->atiCod }}" name="atividade"></input>
           <b>Data e Horario:  </b><select name="horario">
           @foreach($horario as $hora)
           <?php
           $horaInicio=substr($hora->horDataIniRealizacao, 11, 8);
           $horaFim=substr($hora->horDataFimRealizacao, 11, 8);
           $data = substr($hora->horDataIniRealizacao, 0, 10);
           $dataFi = date('d/m/Y',strtotime($data));
           ?>
           <option value="{{ $hora->horCod }}">{{ $dataFi }} |  {{ $horaInicio }} - {{ $horaFim }}</option>
           @endforeach

         </select> &nbsp;<button class="btn btn-primary" name="Gerar" type="submit">Gerar Lista Virtual</button>
         

       </div> 
     </form>
   </fieldset>

   <form method="post" action="/atividades/minhas_atividades/informacoes/listapresenca" >

    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="atv" value="{{ $dados->atiCod }}">
    <center><legend>Lista de Presença Virtual</legend></center>
    <b>Data e Horário: </b><select name="horario">
    @foreach($horario as $hora)
    <?php
    $horaInicio=substr($hora->horDataIniRealizacao, 11, 8);
    $horaFim=substr($hora->horDataFimRealizacao, 11, 8);
    $data = substr($hora->horDataIniRealizacao, 0, 10);
    $dataFi = date('d/m/Y',strtotime($data));
    ?>
    <option value="{{ $hora->horCod }}">{{ $dataFi }} |  {{ $horaInicio }} - {{ $horaFim }}</option>
    @endforeach

  </select> <button class="btn btn-primary" type="submit" name="Listar">Listar</button>


  <br>
  <br>
  <input type="hidden" name="horario" value="{{ $codHorario }}">
  <table class="table table-striped" border="1">
    <thead>
      <tr>
        <th>Nome</th>
        <th>Matrícula</th>
        <th>Ausente.</th>
      </tr>
    </thead>
    @foreach($inscritos as $insc)
    @if($insc->freParticipacao==1)
    <tr><td>{{ $insc->name }}</td><td>{{ $insc->usuMatricula }}</td><td><input type="checkbox" name="{{ $insc->insCod }}" value="1" checked><b></b></td></tr>
    @else
    <tr><td>{{ $insc->name }}</td><td>{{ $insc->usuMatricula }}</td><td><input type="checkbox" name="{{ $insc->insCod }}" value="1"><b></b></td></tr>
    @endif
    
    @endforeach


  </table>
  <center><input type="submit" class="btn btn-primary" value="Submeter" name="submete"></input></center>
</form>
</fieldset>






</div>




<div role="tabpanel" class="tab-pane" id="settings">

 <div id="calendar" class="fc fc-ltr fc-unthemed">



 </div>



</div>
</div>


<script>
 $(function () {

        /* initialize the external events
        -----------------------------------------------------------------*/
        function ini_events(ele) {
          ele.each(function () {

            // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
            // it doesn't need to have a start or end
            var eventObject = {
              title: $.trim($(this).text()) // use the element's text as the event title
            };

            // store the Event Object in the DOM element so we can get to it later
            $(this).data('eventObject', eventObject);

            // make the event draggable using jQuery UI
            $(this).draggable({
              zIndex: 1070,
              revert: true, // will cause the event to go back to its
              revertDuration: 0  //  original position after the drag
            });

          });
        }
        ini_events($('#external-events div.external-event'));

        /* initialize the calendar
        -----------------------------------------------------------------*/
        //Date for the calendar events (dummy data)
        var date = new Date();
        var d = date.getDate(),
        m = date.getMonth(),
        y = date.getFullYear();
        $('#calendar').fullCalendar({
          header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
          },
          buttonText: {
            Hoje: 'today',
            Mes: 'month',
            Semana: 'week',
            Dia: 'day'
          },
          //Random default events
          events: [
          @foreach ($horario as $dt)
          {
            title: '{{ $dados->atiNome }}',
            <?php

            $dataI = substr($dt->horDataIniRealizacao, 0, 10);
            $dataF = substr($dt->horDataFimRealizacao, 0, 10);
            $dataIn = date('d-m-Y',strtotime($dataI));
            $dataFi = date('d-m-Y',strtotime($dataF));
            $diaInicio=date('d',strtotime($dataIn)); 
            $mesInicio=date('m',strtotime($dataIn)); 
            $anoInicio=date('Y',strtotime($dataIn)); 
            $diaFim=date('d',strtotime($dataFi)); 
            $mesFim=date('m',strtotime($dataFi)); 
            $anoFim=date('Y',strtotime($dataFi));

            $mesInicio=$mesInicio-1; 
            $mesFim=$mesFim-1; 

            $horaInicio=$dt->horDataIniRealizacao;
            $horaIni = substr($horaInicio, 11, 8); 
            $horaFim = $dt->horDataFimRealizacao;
            $horaFinal= substr($horaFim, 11, 8);
            $horaInicio=date('H',strtotime($horaIni)); 
            $minutoInicio=date('i',strtotime($horaIni));
            $horaF=date('H',strtotime($horaFinal)); 
            $minutoF=date('i',strtotime($horaFinal));

            ?>
            start: new Date({{ $anoInicio }}, {{ $mesInicio }}, {{ $diaInicio }}, {{ $horaInicio }}, {{ $minutoInicio }}),
            end: new Date({{ $anoFim }}, {{ $mesFim }}, {{ $diaFim }}, {{ $horaF }}, {{ $minutoF }}),
              backgroundColor: "#FFD700", //red
              borderColor: "#FFD700" //red
            },
            @endforeach 

            {
             title: 'Click for Google',
             start: new Date(1997, m, 28),
             end: new Date(1997, m, 29),
             url: 'http://google.com/',
              backgroundColor: "#3c8dbc", //Primary (light-blue)
              borderColor: "#3c8dbc" //Primary (light-blue)
            }
            ],
            editable: false,
          droppable: false, // this allows things to be dropped onto the calendar !!!
          drop: function (date, allDay) { // this function is called when something is dropped

            // retrieve the dropped element's stored Event Object
            var originalEventObject = $(this).data('eventObject');

            // we need to copy it, so that multiple events don't have a reference to the same object
            var copiedEventObject = $.extend({}, originalEventObject);

            // assign it the date that was reported
            copiedEventObject.start = date;
            copiedEventObject.allDay = allDay;
            copiedEventObject.backgroundColor = $(this).css("background-color");
            copiedEventObject.borderColor = $(this).css("border-color");

            // render the event on the calendar
            // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
            $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

            // is the "remove after drop" checkbox checked?
            if ($('#drop-remove').is(':checked')) {
              // if so, remove the element from the "Draggable Events" list
              $(this).remove();
            }

          }
        });

        /* ADDING EVENTS */
        var currColor = "#3c8dbc"; //Red by default
        //Color chooser button
        var colorChooser = $("#color-chooser-btn");
        $("#color-chooser > li > a").click(function (e) {
          e.preventDefault();
          //Save color
          currColor = $(this).css("color");
          //Add color effect to button
          $('#add-new-event').css({"background-color": currColor, "border-color": currColor});
        });
        $("#add-new-event").click(function (e) {
          e.preventDefault();
          //Get value and make sure it is not null
          var val = $("#new-event").val();
          if (val.length == 0) {
            return;
          }

          //Create events
          var event = $("<div />");
          event.css({"background-color": currColor, "border-color": currColor, "color": "#fff"}).addClass("external-event");
          event.html(val);
          $('#external-events').prepend(event);

          //Add draggable funtionality
          ini_events(event);

          //Remove event from text input
          $("#new-event").val("");
        });
      });
    </script>

    @endsection