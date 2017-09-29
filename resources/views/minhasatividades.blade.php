@extends('layouts.master')
@section('titlesection', 'Minhas Atividades')
@section('atividadesAtivo','active')
@section('css')
@parent
<link rel="stylesheet" href="{{ asset('data/plugins/fullcalendar/fullcalendar.min.css') }}">
<link rel="stylesheet" href="{{ asset('data/plugins/fullcalendar/fullcalendar.print.css') }}" media="print">
@endsection
@section('principal')
@parent



<div>

  <!-- Nav tabs -->

  <section class="content">
  <div class="row">

    <div class="col-md-6 col-xs-12 col-sm-12 col-lg-6">


  <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
      <li class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Cursos</a></li>
      <li ><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Palestras</a></li>
    </ul>






  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">
      <fieldset>
        <center><legend>Cursos</legend></center>

         @foreach($ativi as $row)
         @if($row->ati_tipAtiCod==2) 


         <form action="/atividades/minhas_atividades/informacoes" method="post" id="{{ $row->atiNome }}">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">

          <div class="small-box bg-yellow">
            <div class="inner">
              <h4>{{ $row->atiNome }}</h4>
              <p>Inscritos: {{ $inscritos[$row->atiCod] }} <br>
                Status: @if($row->ati_staCod==6) Cadastrar Horários e Datas p/ realização da atividade
                @elseif($row->ati_staCod==8)
                Periodo de Inscrições
                @elseif($row->ati_staCod==7)
                Espera pelo periodo de inscrições.
                @else($row->ati_staCod==9)
                Fim do periodo de incrições
                @endif </p>
              </div>
              <input type="hidden" name="Codigo" value="{{ $row->atiCod }}"></input>
              @if($row->ati_staCod==6) 
              <input type="hidden" name="Status" value="6"></input>
              <a href="#" onClick="document.getElementById('{{ $row->atiNome }}').submit();"  class="small-box-footer">
                Clique Aqui para Definir Horários <i class="fa fa-arrow-circle-right"></i>
              </a>
              @elseif($row->ati_staCod==8 || $row->ati_staCod==9)
              <input type="hidden" name="Status" value="8"></input>
              <a href="#" onClick="document.getElementById('{{ $row->atiNome }}').submit();"  class="small-box-footer">
                Acompanhar Atividade <i class="fa fa-arrow-circle-right"></i>
                </a>
              @elseif($row->ati_staCod==7)
                 <input type="hidden" name="Status" value="6"></input>
              <a href="#" onClick="document.getElementById('{{ $row->atiNome }}').submit();"  class="small-box-footer">
                Visualizar dados da Atividade <i class="fa fa-arrow-circle-right"></i>
              </a>
              @endif


              
              
              
            </div>
          </form>
          @endif
          @endforeach

          

      </fieldset>
    </div>
    <div role="tabpanel" class="tab-pane" id="profile">
      <fieldset>
        <center><legend>Palestras</legend></center>
         @foreach($ativi as $row)
         @if($row->ati_tipAtiCod==3) 
            
            <form action="/atividades/minhas_atividades/informacoes" method="post" id="{{ $row->atiNome }}">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">

          <div class="small-box bg-green">
            <div class="inner">
              <h4>{{ $row->atiNome }}</h4>
              <p>Inscritos: {{ $inscritos[$row->atiCod] }} <br>
                Status: @if($row->ati_staCod==6) Cadastrar Horários e Datas p/ realização da atividade
                @elseif($row->ati_staCod==8)
                Periodo de Inscrições
                @elseif($row->ati_staCod==7)
                Espera pelo periodo de inscrições.
                @else($row->ati_staCod==9)
                Fim do periodo de incrições
                @endif </p>
              </div>
              <input type="hidden" name="Codigo" value="{{ $row->atiCod }}"></input>
              @if($row->ati_staCod==6) 
              <input type="hidden" name="Status" value="6"></input>
              <a href="#" onClick="document.getElementById('{{ $row->atiNome }}').submit();"  class="small-box-footer">
                Clique Aqui para Definir Horários <i class="fa fa-arrow-circle-right"></i>
              </a>
              @elseif($row->ati_staCod==8 || $row->ati_staCod==9)
              <input type="hidden" name="Status" value="8"></input>
              <a href="#" onClick="document.getElementById('{{ $row->atiNome }}').submit();"  class="small-box-footer">
                Acompanhar Atividade <i class="fa fa-arrow-circle-right"></i>
                </a>
              @elseif($row->ati_staCod==7)
                 <input type="hidden" name="Status" value="6"></input>
              <a href="#" onClick="document.getElementById('{{ $row->atiNome }}').submit();"  class="small-box-footer">
                Visualizar dados da Atividade <i class="fa fa-arrow-circle-right"></i>
              </a>
              @endif


              
              
              
            </div>
          </form>





        @endif
        @endforeach

    </fieldset>
  </div>
  </div>
</div>
</div>


<div class="row">
        <div class="col-md-6 col-xs-12 col-sm-12 col-lg-6" id="calendar"></div>
      </div>
</div>

</section>



<script type="text/javascript">


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
          @foreach ($ativi as $at)
          @if($dt->hor_atiCod == $at->atiCod)
          {

            title: '{{ $at->atiNome }}',
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
            @if($at->ati_tipAtiCod==2)
            backgroundColor: "#FFD700", //red
              borderColor: "#FFD700" //red
              @elseif($at->ati_tipAtiCod==3)
            backgroundColor: "#008000", //green
              borderColor: "#008000" //green
              @endif
              
            },
            @endif
            @endforeach
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

    @section('js')
    @parent
    <script type="text/javascript" src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('data/plugins/fullcalendar/fullcalendar.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('data/plugins/fullcalendar/lang/pt-br.js') }}"></script>
    @endsection

