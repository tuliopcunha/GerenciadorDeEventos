<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>Lista de Presença {{ $ativi->atiNome }}</title>
</head>
<body>

  <main>
   <div class="section">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <center>
            <table border="1" width="100%" style="border: solid">
              <tbody>
                <tr>
                  <th>
                    <center>
                      <h3>Sistema Gerenciador de Eventos<br>
                        <div>
                          <img src="{{ asset('data/dist/img/iconedoif.ico') }}">
                        </div>
                        <br>IFMG - Campus Formiga
                        <br>Gerado em: {{ $date }}</h3>
                      </center>
                    </th>
                  </tr>
                </tbody>
              </table>
            </center>
            <br>
            <br>
            <div class="col-md-6">
              <b>Atividade: {{ $ativi->atiNome }}</b>
              <br>


              <!-- ALTERAR ALTERAR ALTERAR -->
              <b>Coordenador:{{ $coordenador->name }}</b>
              <br>
            </div>
            <div class="col-md-6">
              <?php
              $horaInicio=substr($datas->horDataIniRealizacao, 11, 8);
              $horaFim=substr($datas->horDataFimRealizacao, 11, 8);
              $data = substr($datas->horDataIniRealizacao, 0, 10);
              $dataFi = date('d/m/Y',strtotime($data));
              $i=0;

              ?>
              <b>Data:{{ $dataFi }}</b>
              <br>
              <b>Horário:{{ $horaInicio }} - {{ $horaFim }}</b>
            </div>
          </div>
        </div>
        <br>
        <br>
        <br>
        <div class="row">
          <table border="1" width="100%" style="border: solid">
            <tbody>
              <tr>
                <th>N°</th>
                <th>Matricula</th>
                <th>Aluno</th>
                <th>Assinatura</th>
              </tr>
              @foreach($alunos as $alu)
              <?php
              $i++;
              ?>
              <tr>

                <td width="5%">{{ $i }}</td>
                <td width="10%">{{ $alu->usuMatricula }}</td>
                <td width="40%">{{ $alu->name }}</td>
                <td width="50%"></td>
                
                
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <br>
        <br>
        <br>
        <div>
        <center>____________________________________________________________________
          <br>Assinatura:{{ $coordenador->name }}</center>
        </div>
      </div>
      </div>
    </body>
    </html>