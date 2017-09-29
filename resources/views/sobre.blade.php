@extends('layouts.master')
@section('titlesection', 'Sobre')
@section('sobreAtivo','active')
@section('principal')
@parent
<section>
  <div class="row">
    <div class="col-md-6">
      <div class="box box-success">
        <div class="box-header with-border"  align="center">
          <i class="fa fa-check"></i>
          <h3 class="box-title">Projeto de Iniciação Científica IFMG - Gerenciador de Eventos</h3>
        </div>
        <div class="box-body">
          <dt>
            Desenvolvido por:
          </dt>
          <dd>
            João Paulo Menezes - joao.paulo.menezes@hotmail.com
          </dd>
          <dd>
            Tulio Parreira Cunha - tuliopcunha5@gmail.com
          </dd>
          <dd>
            Guilherme Henrique - guilhermehtk@hotmail.com
          </dd>
          <br>
          <dt>
          Orientadores:
          </dt>
          <dd>
            Prof. Mário Luiz Rodrigues Oliveira
          </dd>
          <dd>
            Prof. Otávio de Souza Martins Gomes
          </dd>
        </div>
      </div>
    </div>
  <div class="col-md-6">
      <div class="box box-success">
        <div class="box-header with-border"  align="center">
          <i class="fa fa-check"></i>
          <h3 class="box-title">Blibiotecas de Código Aberto</h3>
        </div>
        <div class="box-body">
          <dt>
            Framework:
          </dt>
          <dd>
         <a href="https://laravel.com/">Laravel</a> 
          </dd>
          <br>
          <dt>
          Layout:
          </dt>
          <dd>
            <a href="https://almsaeedstudio.com/AdminLTE">AdminLte</a>
          </dd>
           <br>
          <dt>
         Blibiotecas:
          </dt>
          <dd>
          <a href="https://github.com/barryvdh/laravel-dompdf">DOMPDF Wrapper for Laravel</a>
          </dd>
          <dd>
          <a href="https://github.com/Xethron/migrations-generator">Laravel Migrations Generator</a>
          </dd>
          <dd>
          <a href="https://github.com/anhskohbo/no-captcha">No CAPTCHA reCAPTCHA</a>
          </dd>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection