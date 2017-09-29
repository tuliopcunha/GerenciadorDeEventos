<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\user;
use App\perfil;
use App\atividade;
use App\evento;
use App\usuario_perfil_atividade;
use App\usuario_perfil_evento;
use DB; 
use Auth;


class PermissoesUsuarioController extends Controller
{


	public function redirecAtividade() {
		session(['permissoes'=>1]);
		return view('permissoes',array('usuarios'=>user::all()));
	}

	public function redirecEvento() {
		session(['permissoes'=>2]);
		return view('permissoes',array('usuarios'=>user::all()));
	}

	public function btnOK(){
		$botao=input::get('OK');
		$id=input::get('NomeUsuario');
		session(['idUsuarioPermissao'=>$id]);
		if (isset($botao)) {
			$dados=user::find($id);
			return view('permissoes_confirmadados',array('usuarios'=>$dados));
		}
	}


	public function ConcedePermissoesAtiv() {
		$botao=input::get('Conceder');
		$verif=0; 
		if (isset($botao)) {
			if(session('permissoes')==1) {
				$atividade= new atividade();
				$atividade->ati_tipAtiCod=1;
				$atividade->ati_staCod=5;
				$atividade->save();
				$query=DB::table('atividade')->max('atiCod');
				$codAtividade=$query;
				$usuAtividade= new usuario_perfil_atividade();
				$usuAtividade->upa_atiCod=$codAtividade;
				$usuAtividade->upa_usuCod=session('idUsuarioPermissao');
				$usuAtividade->upa_perCod=3;
				$usuAtividade->save(); 
				$verif=1;
			} elseif (session('permissoes')==2) {
				$evento=new evento();
				$evento->eve_usuCod=session('idUsuarioPermissao');
				$evento->eve_tipCobCod=1;
				$evento->eve_tipEveCod=1;
				$evento->eve_tipPagCod=1;
				$evento->eve_staCod=5; 
				$evento->save();
				$query='';
				$query=DB::table('evento')->max('eveCod');
				$codevento=$query;
				$usuevento= new usuario_perfil_evento();
				$usuevento->upe_eveCod=$codevento;
				$usuevento->upe_perCod=3;
				$usuevento->upe_usuCod=session('idUsuarioPermissao');
				$usuevento->save();
				$verif=1;
			}
			if ($verif==1){
				SessionController::seedSession();
				$query=user::find(session('idUsuarioPermissao'));
				if(session('permissoes')==1) {
					$mens ="Permissao para criar uma atividade concedida ao usuário ".$query->name;
					return view('mensagens',array('mensagem'=>$mens));
				} else if(session('permissoes')==2){
					$mens ="Permissao para criar um evento concedida ao usuário ".$query->name;
					return view('mensagens',array('mensagem'=>$mens));
				}
			}
		}
	}

}
