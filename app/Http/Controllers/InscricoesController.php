<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use App\atividade;
use App\endereco; 
use App\horario_dia; 
use App\evento; 
use App\inscricao;
use App\log;
use App\usuario_perfil_atividade;
use Mail;
use DB;
use Auth;

class InscricoesController extends MinhasAtividadesController
{

	public function ParticipaAtividade() {
		$botao=input::get('Participar');
		$usuario=session('id');
		$cancelar=input::get('Cancelar');
		$atividade=input::get('Codigo');
		if (isset($botao)){
			$verifica=$this->verificaHorarios($usuario,$atividade);
			if ($verifica!=0) {
				
				$at=atividade::find($verifica);
				$mensagem="Impossível participar da atividade. Existe conflito de horario com a atividade ". strtoupper($at->atiNome) .". Por favor, verifique seus horários";
				
				$codusuario=session('id'); 
				date_default_timezone_set('Brazil/East');
				date_default_timezone_set('America/Sao_Paulo');
				$dataa = date('Y-m-d H:i:s'); 
				$atividades=array(); 
				$i=0; 
				$consulta=Db::table('atividade')
				->join('inscricao','atiCod','=','ins_atiCod')
				->join('horario_dia','atiCod','=','hor_atiCod')
				->where('ins_usuCod',$codusuario)
				->where ('horDataFimRealizacao','>=',$dataa)->groupby('atiCod')->get();
				$cod=input::get('Codigo');
				$query=DB::table('atividade')
				->join('inscricao','atiCod','=','ins_atiCod')
				->where('ins_usuCod',session('id'))
				->where('ins_atiCod',$cod)->get();
				$atividade=atividade::find($cod);
				$endereco=endereco::find($atividade->ati_endCod);
				$horario=horario_dia::all();

				$eve=0;
				if($atividade->ati_eveCod != NULL){
					$eve=Evento::find($atividade->ati_eveCod);
					$verif=0;
				} 
				else{
					$verif=1;
				} 
				
				if(!$query){

					return view ('maisinformacoes',array('dados'=>$atividade, 'ende'=>$endereco, 'hor'=>$horario, 'inscrito'=>1,'ativi'=>$consulta, 'mensagem'=>$mensagem,'ver'=>$verif,'evento'=>$eve));
				}else{
					return view ('maisinformacoes',array('dados'=>$atividade, 'ende'=>$endereco, 'hor'=>$horario, 'inscrito'=>2,'ativi'=>$consulta, 'mensagem'=>$mensagem,'ver'=>$verif,'evento'=>$eve));
				}



			}elseif($verifica==0){
				$query = DB::table('inscricao')
				->where('ins_atiCod',$atividade)->count(); 
				$atv=atividade::find($atividade);
				if ($atv->atiNumVagas>$query){
					$inscricao = new inscricao();
					$inscricao->insPgtoRealizado='Nao';
					$inscricao->insFrequencia='0';
					$inscricao->ins_tipPagCod=1; 
					$inscricao->ins_atiCod=$atividade;
					$inscricao->ins_usuCod=$usuario; 
					$inscricao->save(); 
					$usuPAtv=new usuario_perfil_atividade();
					$usuPAtv->upa_atiCod=$atividade;
					$usuPAtv->upa_usuCod=$usuario;
					$usuPAtv->upa_perCod=1; 
					$usuPAtv->save(); 
					$user = Auth::user();
					Mail::send('emailconfirmacaoinscricao', ['user' => $user,'inscricao' => $inscricao, 'atividade' => $atv], function ($message) use ($user,$inscricao,$atividade) {
						$message->from('inscricoes@eventosifmg.com', 'Eventos IFMG');
						$message->to($user->email, $user->name)->subject('Inscrição Confirmada');
					});
					return view('mensagens',array('mensagem'=>'Inscrito com sucesso!'));
				} else{
					return view('mensagens',array('mensagem'=>'Todas as vagas da atividade desejada já foram preenchidas'));
				}
			}
		}elseif(isset($cancelar)){
			$query=DB::table('inscricao')
			->where('ins_usuCod',$usuario)
			->where('ins_atiCod',$atividade)->delete(); 
			$query=db::table('usuario_perfil_atividade')
			->where('upa_usuCod',$usuario)
			->where('upa_atiCod',$atividade)->delete(); 

			if($query){
				$log = new log();
				$log->logAcao="Inscrição Cancelada na Atividade de Código ".$atividade;
				$log->log_usuCod=$usuario;
				$log->save();
				return view('mensagens',array('mensagem'=>'Sua inscrição foi cancelada'));
			}

		}
		
	}
	function verificaHorarios($codUsuario, $codAtividade) {
		$query = DB::table('atividade')
		->join('inscricao','atiCod','=','ins_atiCod')
		->join('horario_dia','atiCod','=','hor_atiCod')
		->where('ins_usuCod',session('id'))
		->where('ati_staCod',8)->get(); 
		$val=0	 ; 
		$roww = Db::table('horario_dia')->where('hor_atiCod',$codAtividade)->get();

		if (!$query){
			$val=0;  
		} else {
			foreach ($roww as $row) {
				foreach ($query as $rowMinhasAtividades) {
					if (($row->horDataIniRealizacao<=$rowMinhasAtividades->horDataFimRealizacao && $row->horDataIniRealizacao>=$rowMinhasAtividades->horDataIniRealizacao && $val==0)){
						$val=$rowMinhasAtividades->atiCod; 
						//break;
						
					} elseif ($row->horDataFimRealizacao<=$rowMinhasAtividades->horDataFimRealizacao && $row->horDataFimRealizacao>=$rowMinhasAtividades->horDataIniRealizacao && $val==0) {
						$val=$rowMinhasAtividades->atiCod; 
						//break;

					}
				}
			}	

		}

		if ($val!=0){
			return $val;
		}else{
			return 0; 
		}


	}
	public function inscreverEvento($nomeDoEvento, $codigoDoEvento){
		session_start();
		$botao=input::get('Participar');
		$usuario=session('id');
		$cancelar=input::get('Cancelar');

		$query=DB::table('atividade')
		->where('ati_eveCod','=',$codigoDoEvento)
		->get();
		$atividadesDoEvento=$query;

		$query=DB::table('evento')
		->where('eveCod',$codigoDoEvento)
		->get();
		$evento=$query[0];		

		if (isset($botao)){
			
			switch ($evento->eve_tieCod) {
				case '0':
			 		# Tipo de inscrição Padrão
				foreach ($atividadesDoEvento as $atividade) {
					$verifica=$this->verificaHorarios($usuario,$atividade->atiCod);
					if ($verifica==2) {
						return view('mensagens',array('mensagem'=>'Você não pode participar dessa atividade. Está ocorrendo conflito de atividades'));
					}elseif($verifica==1){
						$query = DB::table('inscricao')
						->where('ins_atiCod','=',$atividade->atiCod)
						->count();

						print_r($atividade);

						if ($atividade->atiNumVagas > $query){
							$inscricao = new inscricao();
							$inscricao->insPgtoRealizado='Nao';
							$inscricao->insFrequencia='0';
							$inscricao->ins_tipPagCod=1; 
							$inscricao->ins_atiCod=$atividade->atiCod;
							$inscricao->ins_usuCod=$usuario; 
							$inscricao->save(); 
							$usuPAtv=new usuario_perfil_atividade();
							$usuPAtv->upa_atiCod=$atividade->atiCod;
							$usuPAtv->upa_usuCod=$usuario;
							$usuPAtv->upa_perCod=1; 
							$usuPAtv->save();
							return back(); 
						} else{
									//return view('mensagens',array('mensagem'=>'Todas as vagas da atividade desejada ja foram preenchidas'));
						}
					}
					
				}
				break;
				
				case '1':
			 		# Tipo de inscrição Exclusivo

				$query=DB::table('inscricao')
				->where('ins_usuCod',$usuario)
				->get();
				$inscricoes=$query;	

				$query=DB::table('atividade')
				->where('ati_eveCod','=',$codigoDoEvento)
				->where('atiIncluidaPcteEvento','=','Sim')
				->get();
				$atividadesDoPacoteEvento=$query;

				$endereco = array();

				foreach ($atividadesDoPacoteEvento as $atividade) {
					$query=DB::table('endereco')
					->where('endCod',$atividade->ati_endCod)
					->get();
					array_push($endereco, $query);	

					foreach ($inscricoes as $inscricao) {
						if($inscricao->ins_atiCod == $atividade->atiCod){
									# usuario ja está inscrito na atividade e por consequencia está no evento
									# e não pode se inscrever em outra atividade
							return view('mensagens',array('mensagem'=>'Você já esta inscrito numa atividade exclusiva deste evento. Caso queria se inscrever em outra atividade, primeiro cancele a outra inscrição.
								<a href="" name="Principal" class="btn btn-primary"> Cadastrar-se Em outra Atividade </a> <br>'));

						}
					}
				}
				$inscrito = 1;
				return view('inscricaoevento',array('atividadesDoPacoteEvento'=>$atividadesDoPacoteEvento, 'inscrito'=>$inscrito, 'enderecos'=>$endereco));
				break;	

				default:
			 		# code...
				break;
			} 

		}elseif(isset($cancelar)){
			foreach ($atividadesDoEvento as $atividade) {
				$query=DB::table('inscricao')
				->where('ins_usuCod','=',$usuario)
				->where('ins_atiCod','=',$atividade->atiCod)
				->delete();

				$query=db::table('usuario_perfil_atividade')
				->where('upa_usuCod','=',$usuario)
				->where('upa_atiCod','=',$atividade->atiCod)
				->delete(); 
			}
			session_commit();
			return back();
		//return view('mensagens',array('mensagem'=>'Inscrição cancelada com sucesso! <br> Clique Aqui para voltar para a página de eventos disponíveis <br> <br><a href="/eventos/disponiveis" name="Principal" class="btn btn-primary"> Voltar Eventos Disponiveis </a> <br>'));
		}
		
	}

}

