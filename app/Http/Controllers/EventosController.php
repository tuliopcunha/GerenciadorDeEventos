<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\Model;
use App\endereco;
use App\evento;
use App\tipo_evento;  
use App\usuario_perfil_evento;
use DB; 

class EventosController extends Controller
{
	public function redirecCriaEvento() {
			return view('criaevento', array('per'=>session('perfis')), array('eve'=>tipo_evento::all()));
	}


	public function cadastraEvento() {

session_start();
DB::transaction(function()
{
			// Básicos
		$nome=Input::get('nome');
		$descricao=Input::get('descricao'); 
		$dataIniInsc=Input::get('dataIniInsc');
		$dataFimInsc=Input::get('dataFimInsc');

    		// Endereço
		$end=array();
		$end=(object)$end; 
		$end->endRua=Input::get('Rua');
		$end->endEstado=Input::get('Estado');
		$end->endCidade=Input::get('Cidade');
		$end->endBairro=Input::get('Bairro');
		$end->endCEP=Input::get('CEP');
		$end->endNumero=Input::get('numero');
		$end->endPais=Input::get('Pais');
		$end->endComplemento=Input::get('Complemento');

			// Pagamento
		$tipoCobranca=Input::get('tipoCobranca');
		$tipoPagamento=Input::get('tipoPagamento');
		$preco=Input::get('preco');

		
		
		$e=new endereco();
		$e->endRua=$end->endRua;
		$e->endEstado=$end->endEstado;
		$e->endCidade=$end->endCidade;
		$e->endBairro=$end->endBairro;
		$e->endCEP=$end->endCEP;
		$e->endNumero=$end->endNumero;
		$e->endPais=$end->endPais;
		$e->endComplemento=$end->endComplemento;
		$e->save(); 

		$query=DB::table('endereco')->max('endCod');
		$codEndereco=$query;


		$codUsuario=session('id'); 

		$query=DB::table('evento')
				 ->join('usuario_perfil_evento','eveCod','=','upe_eveCod')
				 ->where('upe_usuCod',$codUsuario)
				 ->where('eve_staCod','=',5)
				 ->get(); 	 
		$codEve=$query[0]->eveCod;

		$codUsuario=Input::get('coordenador');

		$queryIns=DB::table('evento')
				->where('eveCod',$codEve)
				->update(['eveNome'=>$nome, 'evePreco'=>$preco, 'eveDescricao'=>$descricao, 'eveDataIniInsc'=>$dataIniInsc, 'eveDataFimInsc'=>$dataFimInsc, 'eve_endCod'=>$codEndereco, 'eve_staCod'=>10, 'eve_usuCod'=>$codUsuario]); 

		$queryIns=DB::table('usuario_perfil_evento')
				->where('upe_eveCod',$codEve)
				->update(['upe_usuCod'=>$codUsuario]);		

		});		
		$this->VerificaCoordenador(); 
		return redirect()->action("MeusEventosController@redirecMeusEventos"); 
	}

	
	public function editaEvento($nomeEvento, $codigoEvento ){

		// Básicos
		//$codigoEvento=Input::get('codigo');
		$nome=Input::get('nome');
		$descricao=Input::get('descricao');

		// Inscrição
		date_default_timezone_set('Brazil/East');
		date_default_timezone_set('America/Sao_Paulo');
		$dataHoje = date('Y-m-d H:i:s'); 
		$tipoInscricao=Input::get('tipoInscricaoEvento');
		$dataIniInsc=Input::get('dataIniInsc');
		$dataFimInsc=Input::get('dataFimInsc');

    	// Endereço
		$end=array();
		$end=(object)$end; 
		$end->endRua=Input::get('Rua');
		$end->endEstado=Input::get('Estado');
		$end->endCidade=Input::get('Cidade');
		$end->endBairro=Input::get('Bairro');
		$end->endCEP=Input::get('CEP');
		$end->endNumero=Input::get('numero');
		$end->endPais=Input::get('Pais');
		$end->endComplemento=Input::get('Complemento');

			// Pagamento
		$tipoCobranca=Input::get('tipoCobranca');
		$tipoPagamento=Input::get('tipoPagamento');
		$preco=Input::get('preco');

		
		// Dados do endereçodo evento
		$e=new endereco();
		$e->endRua=$end->endRua;
		$e->endEstado=$end->endEstado;
		$e->endCidade=$end->endCidade;
		$e->endBairro=$end->endBairro;
		$e->endCEP=$end->endCEP;
		$e->endNumero=$end->endNumero;
		$e->endPais=$end->endPais;
		$e->endComplemento=$end->endComplemento;
		$e->save(); 

		$query=DB::table('endereco')->max('endCod');
		$codEndereco=$query;

		//Dados do usário atual da sessão
		$codUsuario=session('id'); 

		// Pegando Dados do Evento Atual
		$query=DB::table('evento')
				 ->where('eveCod','=',$codigoEvento)
				 ->get(); 	 
		$meuEvento=$query[0];


		$query=DB::table('users')
				->where('id',session('id'))
				->get();
		$novoCoordenador = $query[0];		


		if (strtotime($dataHoje) < strtotime($meuEvento->eveDataIniInsc)){
			$queryIns=DB::table('evento')
					->where('eveCod',$meuEvento->eveCod)
					->update(['eveNome'=>$nome, 'evePreco'=>$preco, 'eveDescricao'=>$descricao, 'eveDataIniInsc'=>$dataIniInsc, 'eveDataFimInsc'=>$dataFimInsc, 'eve_endCod'=>$codEndereco, 'eve_staCod'=>10, 'eve_usuCod'=>$codUsuario, 'eve_tieCod'=>$tipoInscricao]); 

			// Atualizando Perfis e Permissões do novoCoordenador		
			$queryIns=DB::table('usuario_perfil_evento')
					->where('upe_eveCod',$codigoEvento)
					->where('upe_usuCod',session('id'))
					->update(['upe_usuCod'=>$novoCoordenador->id]);

			if($novoCoordenador->usu_TipoPerfil <> 2){
				$queryIns=DB::table('users')
					->where('id',$codUsuario)
					->update(['usu_TipoPerfil'=>3]);					
			}
			
			return view('mensagens', array('mensagem'=>'<h1> Evento Editado Com Sucesso </h1> <br>  Clique no botão abaixo para voltar para a sua página de eventos ou para voltar ao início<br> <br> <a href="/eventos/meus_eventos" <button type="submit" name="Principal" class="btn btn-primary">Voltar Ao Seus Eventos</button></a> <br>
				', 'retorno'=>'/eventos/inscritos'));
		}else{
			return view('mensagens', array('mensagem'=>'<h1> Erro na Edição </h1> <br> Eventos só podem ser alterados Antes da Data de Inscrição <br>  Clique no botão abaixo para voltar para a sua página de eventos ou para voltar ao início<br> <br> <a href="/eventos/meus_eventos" <button type="submit" name="Principal" class="btn btn-primary">Voltar Ao Seus Eventos</button></a> <br>                    ', 'retorno'=>'/eventos/inscritos'));
		}
	}

	function redirectAdicionarCoordenadorEvento($nomeEvento,$codigoEvento){
		$query=DB::table('evento')
			->where('eveCod',$codigoEvento)
			->get();	
		$meuEvento = $query[0];	

		$query=DB::table('users')
			->get();
		$usuarios = $query;

		$query=DB::table('usuario_perfil_evento')
			->join('users','upe_usuCod','=','id')
			->where('upe_eveCod',$codigoEvento)
			->where('upe_perCod',3)
			->get();
		$coordenadores = $query;		
			
		return view('adicionarcoordenadorevento', array('meuEvento'=>$meuEvento, 'usuarios'=>$usuarios, 'coordenadores'=>$coordenadores, 'nomeEvento'=>$nomeEvento, 'codigoEvento'=>$codigoEvento));
	}

	function adicionarCoordenadorEvento($nomeEvento,$codigoEvento,Request $request){
		$adiciona=input::get('OK');
		$usuario=session('id');
		$remove=input::get('X');

		if(isset($adiciona)){
			$query=DB::table('users')
			->where('id',Input::get('usuario'))
			->get();
			$novoCoordenador = $query[0];

			$queryIns=DB::table('usuario_perfil_evento')
			->where('upe_eveCod',$codigoEvento)
			->where('upe_usuCod',$novoCoordenador->id)
			->get();
			$relacaoEventoUsuario = $queryIns;



			if(sizeof($relacaoEventoUsuario) <> 0){
				print_r($codigoEvento);			
				$queryIns=DB::table('usuario_perfil_evento')
				->where('upe_eveCod',$codigoEvento)
				->where('upe_usuCod',$novoCoordenador->id)
				->update(['upe_perCod'=>3]);
				session_commit();		
			} else {
				$relacaoEventoUsuario = new usuario_perfil_evento();
				$relacaoEventoUsuario->upe_eveCod = $codigoEvento;
				$relacaoEventoUsuario->upe_perCod = 3;
				$relacaoEventoUsuario->upe_usuCod = $novoCoordenador->id;
				$relacaoEventoUsuario->save();
				session_commit();
			}			

			$this->VerificaCoordenador();

			if($novoCoordenador->usu_TipoPerfil <> 2){
				$queryIns=DB::table('users')
				->where('id',$novoCoordenador->id)
				->update(['usu_TipoPerfil'=>3]);					
			}
		}


		return back();	
	}
			

	function VerificaCoordenador(){
		$perfil_Atv=db::table('atividade')
		->join('usuario_perfil_atividade','atiCod','=','upa_atiCod')
		->where('upa_usuCod',session('id'))
		->where ('ati_staCod',5)->get();

		$perfil_Eve=db::table('evento')
		->join('usuario_perfil_evento','eveCod','=','upe_eveCod')
		->where('upe_usuCod',session('id'))
		->where ('eve_staCod',5)->get();

		if (($perfil_Eve)&&($perfil_Atv)){
			session(['CoordenadorPermissoes'=>3]); 
		}
		elseif($perfil_Atv){
			session(['CoordenadorPermissoes'=>1]); 
		}
		elseif($perfil_Eve){
			session(['CoordenadorPermissoes'=>2]); 
		}else{
			session(['CoordenadorPermissoes'=>0]); 
		}
	}
}
