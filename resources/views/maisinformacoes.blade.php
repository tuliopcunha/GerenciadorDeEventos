@extends('layouts.master')
@section('titlesection', 'Atividade')
@section('atividadesAtivo','active')
@section('css')
@parent
<link rel="stylesheet" href="{{ asset('data/plugins/fullcalendar/fullcalendar.min.css') }}">
<link rel="stylesheet" href="{{ asset('data/plugins/fullcalendar/fullcalendar.print.css') }}" media="print">
@endsection
@section('principal')
@parent


<form action="/Inscreve" method="post">
  {!! csrf_field() !!}
  <input type="hidden" name="Codigo" value="{{ $dados->atiCod }}">


  <div class="row">
   <div class="col-md-3">
    <div class="box box-success">
      <div class="box-body box-profile">
        <?php

        $dataI = substr($dados->atiDataIniInsc, 0, 10);
        $dataF = substr($dados->atiDataFimInsc, 0, 10);
        $dataIn = date('d/m/Y',strtotime($dataI));
        $dataFi = date('d/m/Y',strtotime($dataF));
        ?>
        

        <h3 class="profile-username text-center">{{ $dados->atiNome }}</h3>

        <p class="text-muted text-center"><i>Início:</i> {{ $dataIn }} &nbsp;&nbsp;<i>Fim:</i> {{ $dataFi }}</p>

        

        @if($inscrito==1)
        <center><button type="submit" class="btn btn-success" name="Participar"> Inscreva-se</button></center>
        @elseif($inscrito==2)
        <center><button type="submit" class="btn btn-danger" name="Cancelar"> Cancelar Inscrição</button></center>
        @elseif($inscrito==3)
        <center><a class="btn btn-primary disabled" name=""> Inscreva-se</a></center>
        @endif

      </div>
      <!-- /.box-body -->
    </div>

    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">Informações de Cadastro</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        

        <strong><i class="fa fa-file-text-o margin-r-5"></i> Notas</strong>

        <p>@if($mensagem=='Não possui informação')
          {{ $mensagem }}
          @else
          <font color="red">{{ $mensagem }}</font>
          @endif</p>
        </div>
        <!-- /.box-body -->
      </div>



    </div>
    <!-- /.col -->
    <div class="col-md-9">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
        <li class="active"><a href="#Calendario" data-toggle="tab" aria-expanded="false">Calendario</a></li>
          <li class="" ><a href="#activity" data-toggle="tab" aria-expanded="false">Atividades</a></li>
          <li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false">Endereço
          </a></li>
      
          <li class=""><a href="#settings" data-toggle="tab" aria-expanded="false">Quadro de Horários</a></li>
          <li class=""><a href="#Vinculos" data-toggle="tab" aria-expanded="false">Evento</a></li>
          

        </ul>
        <div class="tab-content">

          <!-- /.tab-pane -->
          <div class="tab-pane active" id="Calendario">
          <div id="calendar"></div>



          </div>






          <div class="tab-pane" id="timeline">
            <!-- The timeline -->
            <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
              <thead>
                <tr role="row"><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">Rua</th><th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column descending" aria-sort="ascending">Bairro</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Numero</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Cidade</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">Conteudo</th></tr>
              </thead>
              <tbody>

                <tr role="row" class="odd">
                  <td class=""><?php 
                    echo $ende->endRua?></td>
                    <td class="sorting_1"></td>
                    <td><?php echo $ende->endBairro?></td>
                    <td><?php echo $ende->endNumero?></td>
                    <td><?php echo $ende->endCidade?></td>
                  </tr>


                </tbody>

              </table>
            </div>
            <!-- /.tab-pane -->
            <!-- atividades-pane -->
            <div class="tab-pane active" id="activity">
              <div class="box">
                <!-- /.box-header -->
                <div class="box-body">
                  <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">

                  <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                    <thead>
                      <tr role="row"><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">Nome</th><th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column descending" aria-sort="ascending">Tipo</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Carga Horaria</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Pré-Requisitos</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">Conteudo</th></tr>
                    </thead>
                    <tbody>

                      <tr role="row" class="odd">
                        <td class="">{{ $dados->atiNome }}</td>
                        <td class="sorting_1">Minicurso</td>
                        <td>{{ $dados->atiCargaHoraria }} hora(s)</td>
                        <td>{{ $dados->atiPreRequisito }}</td>
                        <td>{{ $dados->atiConteudo }}</td>
                      </tr>


                    </tbody>
                    
                  </table></div></div>
                  
                </div>
              </div>
              <!-- /.box-body -->
            </div>
          </div>


          <div class="tab-pane" id="settings">
           
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
            ?>
            @foreach($hor as $horario)
            @if($horario->hor_atiCod==$dados->atiCod)
            <?php 
            $horaInicio=$horario->horDataIniRealizacao;
            $horaIni = substr($horaInicio, 11, 8); 
            $horaFim = $horario->horDataFimRealizacao;
            $horaF= substr($horaFim, 11, 8); 
            ?>
            <tr>
             <td>{{ $dados->atiNome }}</td>
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



      <div role="tabpanel" class="tab-pane" id="Vinculos">


  <div class="row">
 <center><legend> <b>Vinculo de Atividade e Evento</b>
          </legend></center>




  <div class="col-md-6 col-xs-12 col-sm-12 col-lg-6">

   <div class="form-group">
          <label for="Instituição"><h4><b>@if($ver==1)
                                            Não possui vinculo</b> </h4></label>
                                            @else
                                            Atividade vinculada ao evento:  {{ $evento->eveNome }}</b> </h4>
                                            @endif</label>
                                            </div>
                                            
          
        </div>

  </div>
  

  </div>
  </div>
    <!-- /.tab-pane -->


    
     
     
     
   </div>
 </div>
 <!-- /.tab-content -->
</div>
<!-- /.nav-tabs-custom <--></-->
</div>
<!-- /.col -->
</div>
 
</form>

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
          @foreach ($hor as $dt)
          @if($dt->hor_atiCod == $dados->atiCod)
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
            @if($dados->ati_tipAtiCod==2)
            backgroundColor: "##FFD700", //yellow
              borderColor: "##FFD700" //yellow
              @elseif($dados->ati_tipAtiCod==3)
            backgroundColor: "#008000", //green
              borderColor: "#008000" //green
              @endif
              

            
            },
            @endif
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