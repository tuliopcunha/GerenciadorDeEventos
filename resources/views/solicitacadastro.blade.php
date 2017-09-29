<!DOCTYPE html>
<html>
<head>
    <title>ContactMe</title>
 
    <!-- Latest compiled and minified CSS -->
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">-->
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"> 
    <link href="{{ asset('data/css/signin.css') }}" rel="stylesheet"> 
    <link href="{{ asset('data/css/signin.css') }}" rel="stylesheet"> 
    <script type="text/javascript" src="{!! asset('js/MaskCpf.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('js/maskCpfPack.js') !!}"></script>
 <script type="text/javascript">$(document).ready(function(){ $("#cpf").mask("999.999.999-99");});</script>
</head>
<body>


<!--<div class="col-lg-4">
                        <h1>Disabled Form States</h1>

                        <form role="form">

                            <fieldset >

                                <div class="form-group">
                                    <label for="disabledSelect">Disabled input</label>
                                    <input class="form-control" type="text" placeholder="Disabled input">
                                </div>

                                <div class="form-group">
                                    <label for="disabledSelect">Disabled select menu</label>
                                    <select id="disabledSelect" class="form-control">
                                        <option>Disabled select</option>
                                    </select>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox">Disabled Checkbox
                                    </label>
                                </div>

                                <button type="submit" class="btn btn-primary">Disabled Button</button>

                            </fieldset>

                        </form>
                        </div>




                        <br><br><br><br><br><br>-->
 
<div class="container">
 
    <h1>Cadastre-se</h1>
    <hr />

    <div class="btn-group" data-toggle="buttons">
  <label class="btn btn-primary active">
    <input type="radio" name="options" id="option1" autocomplete="off" checked> Informações Pessoais &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  </label>
</div>
<br>
<br>
 
    <form action="/SolicitaCadastro" method="POST">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <div class="col-lg-4">
      <center><legend>Informe Seus Dados</legend></center>
      <fieldset>
      
      <div class="form-group">
        <label for="nome">Nome</label>
        <input type="text" id="nome" name="nome"  required class="form-control" placeholder="Nome">
      </div>
      <div class="form-group">
        <label for="Email">Email</label>
        <input type="email" id="inputEmail" name="Email" required autofocus class="form-control" placeholder="Email">
      </div>
      <div class="form-group">
        <label for="CPF">CPF</label>
        <input type="text" id="cpf" name="CPF" required class="form-control" placeholder="CPF">
      </div>
      
      
      

      <button type="submit" name="Solicitar" class="btn btn-primary">Solicitar Cadastro</button>
      <button type="Reset" name="Apagar" class="btn btn-primary">Limpar</button>
      </fieldset>
      </div>
 
    </form> 
 
</div>
 
</body>
</html>