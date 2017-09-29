@extends('layouts.master')
@section('title', '')
@section('titlesection', 'Defina os horários da sua atividade')
@section('descsection', '')
@section('principal')
@parent
<head>
	
	<script>
		function mascara(o,f){
			v_obj=o
			v_fun=f
			setTimeout("execmascara()",1)
		}
		function execmascara(){
			v_obj.value=v_fun(v_obj.value)
		}

		function id( el ){
			return document.getElementById( el );
		}

    // aqui começa as mascaras 

    function mtel(v){ //MASCARA PARA TELEFONE

        v=v.replace(/\D/g,"");             //Remove tudo o que não é dígito
        v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
        v=v.replace(/(\d)(\d{4})$/,"$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
        return v;
    }


    function mcpf(v){  //MASCARA PARA CPF

        v=v.replace(/\D/g,"")                    //Remove tudo o que não é dígito
        v=v.replace(/(\d{3})(\d)/,"$1.$2")       //Coloca um ponto entre o terceiro e o quarto dígitos
        v=v.replace(/(\d{3})(\d)/,"$1.$2")       //Coloca um ponto entre o terceiro e o quarto dígitos
                                                 //de novo (para o segundo bloco de números)
        v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2") //Coloca um hífen entre o terceiro e o quarto dígitos
        return v;
    }

    function mcnpj(v){  //MASCARA PARA CNPJ

        v=v.replace(/\D/g,"")                    //Remove tudo o que não é dígito

        v=v.replace(/(\d{2})(\d)/,"$1.$2")
        v=v.replace(/(\d{3})(\d)/,"$1.$2")
        v=v.replace(/(\d{3})(\d)/,"$1/$2")       	 
         v=v.replace(/(\d)(\d{2})$/,"$1-$2");    //Coloca o . antes dos últimos 3 dígitos, e antes do verificador 
         return v;
     }

    function mie(v){  //MASCARA PARA CNPJ

        v=v.replace(/\D/g,"")                    //Remove tudo o que não é dígito      	 
        v=v.replace(/(\d{3})(\d)/,"$1.$2")
        v=v.replace(/(\d{3})(\d)/,"$1.$2")
        v=v.replace(/(\d{3})(\d)/,"$1.$2")
        return v;
    }


    function mrg(v){  //MASCARA PARA RG

        //  v=v.replace( /\s/g, '' );                  //Remove tudo o que não é dígito
    	//	v=v.replace(/(\d)(\d{7})$/,"$1.$2");   	 //Coloca o . antes dos últimos 3 dígitos, e antes do verificador
        //  v=v.replace(/(\d)(\d{4})$/,"$1.$2");    //Coloca o . antes dos últimos 3 dígitos, e antes do verificador
        //  v=v.replace(/(\d)(\d)$/,"$1-$2");       //Coloca o - antes do último dígito

    	v=v.replace(/(\d{2})(\d)/,"$1.$2")       //Coloca um ponto entre o segundo e o terceiro dígitos
    	v=v.replace(/(\d{3})(\d)/,"$1.$2")     
    	v=v.replace(/(\d{5})(\d)/,"$1.$2")     
    	v=v.replace(/(\d{9})(\d)/,"$1-$2")       
    	return v;
    }

    function mcep(v){  //MASCARA PARA CEP

        v=v.replace(/\D/g,"")                      //Remove tudo o que não é dígito
        v=v.replace(/^(\d{5})(\d)/,"$1-$2")         //Esse é tão fácil que não merece explicações
        return v;
    }

    function mcartao(v){ //MASCARA PARA CARTAO

        v=v.replace(/\D/g,"")                    //Remove tudo o que não é dígito
        v=v.replace(/(\d{4})(\d)/,"$1.$2")       //Coloca um ponto entre o terceiro e o quarto dígitos
        v=v.replace(/(\d{4})(\d)/,"$1.$2")       //Coloca um ponto entre o terceiro e o quarto dígitos
    	v=v.replace(/(\d{4})(\d)/,"$1.$2")       //Coloca um ponto entre o terceiro e o quarto dígitos
    	v=v.replace(/(\d{4})(\d)/,"$1.$2")       //Coloca um ponto entre o terceiro e o quarto dígitos
    	return v;
    }

    function mdata(v){ // MASCARA PARA DATA 

        v=v.replace(/\D/g,"");                    //Remove tudo o que não é dígito
        v=v.replace(/(\d{2})(\d)/,"$1/$2");
        v=v.replace(/(\d{2})(\d)/,"$1/$2");
        return v;
    }

    function mvalor(v){  //MASCARA PARA VALOR EM $$

        v=v.replace(/\D/g,"");//Remove tudo o que não é dígito
        v=v.replace(/(\d)(\d{8})$/,"$1.$2");//coloca o ponto dos milhões
        v=v.replace(/(\d)(\d{5})$/,"$1.$2");//coloca o ponto dos milhares

        v=v.replace(/(\d)(\d{2})$/,"$1,$2");//coloca a virgula antes dos 2 últimos dígitos
        return v;
    }

    function mvalor(v){  //MASCARA PARA VALOR EM $$

        v=v.replace(/\D/g,"");//Remove tudo o que não é dígito
        v=v.replace(/(\d)(\d{8})$/,"$1.$2");//coloca o ponto dos milhões
        v=v.replace(/(\d)(\d{5})$/,"$1.$2");//coloca o ponto dos milhares

        v=v.replace(/(\d)(\d{2})$/,"$1,$2");//coloca a virgula antes dos 2 últimos dígitos
        return v;
    }

    function memail(v){

    	v=v.replace( /\s/g, '' );
    	return v;
    }

    window.onload = function(){ // FUNCAO QUE É ACIONADO AO CARREGAR A PAGINA ( WINDOW.ONLOAD )
id('Telefone2').onkeyup = function(){ //ATRIBUI O CAMPO COM ID txtFixo A MASCARA DE TELEFONE
    		mascara( this, mtel );
    	}

id('CEP').onkeyup = function(){ //ATRIBUI O CAMPO COM ID txtCel A MASCARA DE TELEFONE
	mascara( this, mcep );
}
    	id('cpf').onkeyup = function(){ //ATRIBUI O CAMPO COM ID txtCel A MASCARA DE TELEFONE
    		mascara( this, mcpf );
    	}
    	
    	id('Telefone1').onkeyup = function(){ //ATRIBUI O CAMPO COM ID txtFixo A MASCARA DE TELEFONE
    		mascara( this, mtel );
    	}
    	
    	id('txtComercial').onkeyup = function(){ //ATRIBUI O CAMPO COM ID txtComercial A MASCARA DE TELEFONE
    		mascara( this, mcep );
    	}

    	id('CEP').onkeyup = function(){ //ATRIBUI O CAMPO COM ID txtFixo A MASCARA DE TELEFONE
    		mascara( this, mcep );
    	}
    	

    	

    }

</script>
</head>
<form action="/CadastroRealizado" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div>
		<!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#dados" aria-controls="dados" role="tab" data-toggle="tab">Dados Pessoais</a></li>
			<li role="presentation"><a href="#informacoes" aria-controls="informacoes" role="tab" data-toggle="tab">Informações de Localização</a></li>
			<li role="presentation"><a href="#formacao" aria-controls="formacao" role="tab" data-toggle="tab">Formação Acadêmica</a></li>
		</ul>
		<!-- Tab panes -->
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="dados">
				<fieldset>
					<center><legend>Dados Pessoais</legend></center>
					<div class="col-lg-4">
						<div class="form-group">
							<label for="nome">Nome</label>
							<input type="text" id="nome" name="nome" value="<?php $dadosPessoais=$_SESSION['dados'];
							$dadosendereco = $_SESSION['dadosEndereco'];
							echo "$dadosPessoais->usuNome"; ?>" class="form-control" placeholder="Nome" required>
						</div>
						<div class="form-group">
							<label for="Email">Email</label>
							<input type="text" id="Email" name="Email" value="<?php echo "$dadosPessoais->usuEmail"; ?>" class="form-control" placeholder="Email"  >
						</div>
						<div class="form-group">
							<label for="CPF">CPF</label>

							<input type="text" id="cpf" name="CPF" value="<?php echo "$dadosPessoais->usuCpf"; ?>" class="form-control" placeholder="CPF" maxlength="14" >
						</div>
						<div class="form-group">
							<label for="RG">RG</label>
							<input type="text" id="RG" name="RG" class="form-control"  value="<?php echo "$dadosPessoais->usuRg"; ?>" placeholder="RG" maxlength="13" >
						</div>
					</div>

					<div class="col-lg-4">
						<div class="form-group">
							<label for="Matricula">Matricula</label>
							<input type="text" id="Matricula" name="Matricula" class="form-control"  value="<?php echo "$dadosPessoais->usuMatricula"; ?>" placeholder="Matricula" >
						</div>
						<div class="form-group">
							<label for="Instituição">Instituição Vinculada</label>
							<input type="text" id="InstVinc" name="InstVinc" class="form-control"  value="<?php echo "$dadosPessoais->usuInstituicaoVinculo"; ?>" placeholder="Instituição Vinculada" >
						</div>      
						<div class="form-group">
							<label for="ObservaçõesEspeciais">Observações Especiais</label>
							<input type="text" id="ObsEsp" name="ObsEsp" class="form-control"  value="<?php echo "$dadosPessoais->usuObsPne"; ?>" placeholder="Observações Especiais" >
						</div>
						<div class="form-group">
							<label for="Lattes">Lattes</label>
							<input type="text" id="Lattes" name="Lattes" class="form-control"  value="<?php echo "$dadosPessoais->usuLattes"; ?>" placeholder="Lattes" >
						</div>
					</div>

					<div class="col-lg-4">
						<div class="form-group">
							<label for="T1">Telefone 1</label>
							<input type="text" id="Telefone1" name="Telefone1"  value="<?php echo "$dadosPessoais->usuTel1"; ?>" class="form-control" placeholder="Telefone 1" maxlength='15'>
						</div>
						<div class="form-group">
							<label for="T1">Telefone 1</label>
							<input type="text" id="Telefone2" name="Telefone1"  value="<?php echo "$dadosPessoais->usuTel1"; ?>" class="form-control" placeholder="Telefone 1" maxlength='15'>
						</div>
						<div class="form-group">
							<label for="Login">Login</label>
							<input type="text" id="Login" name="Login" class="form-control"  value="<?php echo "$dadosPessoais->usuLogin"; ?>" placeholder="Login">
						</div>
						<div class="form-group">
							<label for="Senha">Senha</label>
							<input type="password" id="Senha" name="Senha" class="form-control"  value="<?php echo "$dadosPessoais->usuSenha"; ?>" placeholder="Senha">
						</div>
					</div>
				</fieldset>
			</div>

			<div role="tabpanel" class="tab-pane" id="informacoes">
				<fieldset>
					<center><legend>Endereço</legend></center>
					<div class="col-lg-6">

						<div class="form-group">
							<label for="Rua">Rua</label>
							<input type="text" id="Rua" name="Rua" value="<?php echo $dadosendereco->endRua?>" class="form-control" placeholder="Rua">
						</div>
						<div class="form-group">
							<label for="Numero">Numero</label>
							<input type="text" id="numero" name="numero" value="<?php echo $dadosendereco->endNumero?>" class="form-control" placeholder="Numero">
						</div>
						<div class="form-group">
							<label for="Bairro">Bairro</label>
							<input type="text" id="Bairro" name="Bairro" class="form-control" value="<?php echo $dadosendereco->endBairro ?>"placeholder="Bairro" >
						</div>
						<div class="form-group">
							<label for="Complemento">Complemento</label>
							<input type="text" id="Complemento" name="Complemento" class="form-control" value="<?php echo $dadosendereco->endComplemento?>" placeholder="Pais" >
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label for="Cidade">Cidade</label>
							<input type="text" id="Cidade" name="Cidade" class="form-control" value="<?php echo $dadosendereco->endCidade?>" placeholder="Cidade" >
						</div>
						<div class="form-group">
							<label for="CEP">CEP</label>
							<input type="text" id="CEP" name="CEP" class="form-control" value="<?php echo $dadosendereco->endCEP?>" placeholder="CEP">
						</div>
						<div class="form-group">
							<label for="Estado">Estado</label>
							<input type="text" id="Estado" name="Estado" class="form-control" value="<?php echo $dadosendereco->endEstado?>" placeholder="Estado">
						</div> 
						<div class="form-group">
							<label for="Pais">País</label>
							<input type="text" id="Pais" name="Pais" class="form-control" value="<?php echo $dadosendereco->endPais?>" placeholder="Pais">
						</div>
					</div>
				</fieldset>


			</div>
			<div role="tabpanel" class="tab-pane" id="formacao">

				<fieldset>
					<center><legend>Formação Acadêmica</legend></center>
					<div class="col-lg-6">
						<div class="form-group">
							<label for="Titulo">Titulo</label>
							<select name="Titulo" class="form-control"> 
								<option value="Doutorado">Doutorado</option>
								<option value="Mestrado">Mestrado</option>
								<option value="Especialista">Especialista</option>
								<option value="Superior Completo">Superior Completo</option>
								<option value="Superior Incompleto">Superior Incompleto</option>
								<option value="Ensino Medio Incompleto">Ensino Medio Incompleto</option>
							</select>
						</div>

						<div class="form-group">
							<label for="Titulo">Título</label>
							<input type="text" id="Instituição" name="Titulo"  value="" class="form-control" placeholder="Instituição">
						</div>
						<div class="form-group">
							<label for="Instituição">Instituição</label>
							<input type="text" id="Instituição" name="Instituição"  value="" class="form-control" placeholder="Instituição">
						</div>
						<div class="form-group">
							<label for="Area_Conhecimento">Area Conhecimento</label>
							<select name="AreaConhacimento" class="form-control">
								<option value="2">Superior Completo</option>
							</select>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label for="Ano">Ano</label>
							<input type="text" id="Ano" name="Ano" class="form-control" value="" placeholder="Ano" required>
						</div>
					</div>

				</fieldset>
				<div align="center">
					<button align="center" type="submit" name="Cadastrar" class="btn btn-primary">Cadastrar-se</button>
				</div>
			</div>
		</form>

		@endsection