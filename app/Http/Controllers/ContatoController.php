<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\Model;
use App\contato;


class ContatoController extends Controller
{
	public function indexHome(){
		return view('contato',array('pagina'=>"home"));
	}
	public function index($pagina){
		return view('contato',array('pagina'=>$pagina));
	}	

	public function criaContato(Request $request){
		$contato = new Contato();
		$contato->con_codUsuario=session('id');
		$contato->conPagina=$request->pagina;
		$contato->conMensagem=$request->mensagem;
		$contato->conAssunto=$request->assunto;
		$contato->save();
		return view('mensagens',array('mensagem'=>'Recebemos sua mensagem, uma resposta será enviado para seu email cadastrado!'));
	}
	
}
