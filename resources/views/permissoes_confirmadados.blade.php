@extends('layouts.master')
@section('titlesection', 'Permissões')
@section('PaineldeControleAtivo','active')
@section('principal')
@parent
<form action="/permissoes/confirma_dados/permissao_concedida" method="post">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">

  <div class="col-lg-4">
    <div class="form-group">
      <label for="disabledSelect">Selecione o usuário para conceder a permissão</label>
      <select id="disabledSelect" class="form-control" name="NomeUsuario" disabled>
        <option value="<?php echo $usuarios->id ?>" selected><?php echo $usuarios->name ?> </option>
      </select>
    </div>
    <div align="center">
      <button type="submit" name="OK" class="btn btn-primary" disabled>Confirmar</button>
    </div>
  </div>
  
  <div class="col-lg-4">
    <div class="form-group">
      <label for="nome">Nome</label>
      <input type="text" id="nome" name="nome" value=" <?php echo $usuarios->name ?>" class="form-control" placeholder="Nome" disabled>
    </div>
    <div class="form-group">
      <label for="Email">Email</label>
      <input type="text" id="Email" name="Email" value="<?php echo $usuarios->email ?>" class="form-control" placeholder="Email" disabled >
    </div>
    <div class="form-group">
      <label for="CPF">CPF</label>
      <input type="text" id="CPF" name="CPF" value="<?php echo $usuarios->usuCpf ?>" class="form-control" placeholder="CPF" disabled >
    </div>
    <div class="form-group">
      <label for="RG">RG</label>
      <input type="text" id="RG" name="RG" class="form-control"  value="<?php echo $usuarios->usuRg ?>" placeholder="RG" maxlength="13" disabled>
    </div>
    <div align="center">
      <button type="submit" name="Conceder" class="btn btn-primary" >Conceder Permissão</button>
    </div>
    <div align="center">
      <br>
      <button onclick="history.go(-1)" class="btn btn-primary" >Voltar</button>
    </div>
  </div>
  
</form>


@endsection