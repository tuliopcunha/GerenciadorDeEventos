@extends('layouts.master')
@section('title', 'Contato')
@section('titlesection', 'Contato')
@section('contatoAtivo', 'active')
@section('principal')
@parent
<section class="content">
  <form action="/contato/" method="post">
    {!! csrf_field() !!}

    <div class="row">
<input type="hidden" value="{{ $pagina }}" name="pagina">
      <div class="col-lg-6">
        <div class="form-group">
          <label for="assunto">Assunto</label>
          <input type="text" name="assunto" class="form-control" maxlength="45" size="45" placeholder="Assunto" required>
        </div>
        <div class="form-group">
          <label for="mensagem">Mensagem</label>
          <textarea class="form-control" rows="6" maxlength="470" name="mensagem" placeholder="Mensagem" style="resize:none" required></textarea>
        </div>
     
      <div align="center">
        <button align="center" type="submit" id="submit" class="btn btn-primary">Enviar</button>
      </div>
      </div>
         </div>

    </form>
  </section>

  @endsection