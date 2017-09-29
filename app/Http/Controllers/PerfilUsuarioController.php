<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\area_conhecimento;
use App\titulo;
use App\endereco;
use App\formacaoacademica;
use Hash;
use Auth;
use DB;

class PerfilUsuarioController extends Controller
{
	public function alteraPerfil(Request $request) {
		DB::table('users')->where('id',session('id'))->update(['usu_UltimoLog'=>$this->verificaPerfil($request->perfil)]);
		SessionController::seedSession();
		return redirect::to('');
	}

	function verificaPerfil($perfil){
		if ($perfil=='Coordenador'){
			return 3;
		}else if($perfil=='Administrador'){
			return 2;
		}else if($perfil=='Participante'){
			return 1;
		}
	}

	public function retornaDados(){
		$user = Auth::user();
		return view('user.meuperfil',array('user' => $user,'endereco'=>Endereco::findOrFail($user->usu_endCod),'formacao'=>FormacaoAcademica::findOrFail($user->usu_forCod),'area_conhecimento'=>Area_Conhecimento::all(),'titulos'=>Titulo::all()));
	}


	public function alteraSenha(Request $request){
		$user = Auth::user();
		if(Hash::check($request->passwordOld, $user->password)){
			if(isset($user->passwordOld)){
				if (Hash::check($request->password, $user->passwordOld)){
					return redirect()->back()
					->withInput($request->only('passwordOld'))
					->withErrors(['password' => 'Senha já definida anteriormente']);
				} else {
					if(isset($user->passwordOld2)){
						if (Hash::check($request->password, $user->passwordOld2)){
							return redirect()->back()
							->withInput($request->only('passwordOld'))
							->withErrors(['password' => 'Senha já definida anteriormente']);
						} else {
							return $this->alteraUsuarioPassword($user,$request->password);
						}
					} else {
						return $this->alteraUsuarioPassword($user,$request->password);
					}
				}
			} else {
				return $this->alteraUsuarioPassword($user,$request->password);
			}
		} else {
			return redirect()->back()
			->withErrors(['passwordOld' => 'Senha atual incorreta']);
		}
	}


	private function alteraUsuarioPassword($user,$password){
		$user->passwordOld2=$user->passwordOld;
		$user->passwordOld=$user->password;
		$user->password=Hash::make($password);
		$user->save();
		return view('mensagens',array('mensagem'=>'Senha Alterada com Sucesso'));
	}



	public function alteraDados(Request $request){
		$user = Auth::user();
		$user->name=$request->nome;
		$user->usuRG=$request->rg;
		$user->usuMatricula=$request->matricula;
		$user->usuInstituicaoVinculo=$request->instvinc;
		$user->usuObsPne=$request->obsesp;
		$user->usuLattes=$request->lattes;
		$user->usuTel1=$request->telefone1;
		$user->usuTel2=$request->telefone2;
		$user->usuDataNascimento=$request->data;
		$user->Save();
		$this->alteraEndereco($request,$user->usu_endCod);
		$this->alteraFormacaoAcademica($request,$user->usu_forCod);
		return $this->retornaDados();
	}

	public function alteraEndereco(Request $request,$id)
	{
		$endereco = Endereco::findOrFail($id);
		$endereco->endNumero=$request->numero; 
		$endereco->endBairro=$request->bairro; 
		$endereco->endCidade=$request->cidade; 
		$endereco->endEstado=$request->uf;    
		$endereco->endCEP=$request->cep; 
		$endereco->endPais=$request->pais; 
		$endereco->endComplemento=$request->complemento; 
		$endereco->endRua=$request->rua;  
		$endereco->Save();
	}

	public function alteraFormacaoAcademica(Request $request,$id)
	{
		$acade= FormacaoAcademica::findOrFail($id);
		$acade->for_titCod=$request->titulo; 
		$acade->for_areCod=$request->areaconhecimento; 
		$acade->forInstituicao=$request->instituicao; 
		$acade->forAno=$request->ano;  
		$acade->Save();
	}

}
