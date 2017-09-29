<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\Model;
use App\atividade;
use App\horario_dia;
use App\endereco;
use App\evento;
use App\User;
use App\usuario_perfil_atividade;
use App\tipo_atividade; 
use DB; 

class AtividadesController extends MinhasAtividadesController
{
	public function redirecCriaAtividade() {


		$query=Db::table('usuario_perfil_atividade')
		->join('atividade','upa_atiCod','=','atiCod')
		->where('upa_perCod',3)
		->where('upa_usuCod',session('id'))
		->where('ati_staCod',5)->get();
		
		return view('criaatividade', array('per'=>session('perfis'), 'evento'=>NULL, 'ati'=>$query, 'enderecoEvento'=>NULL, 'dataIniInscricao'=>NULL ,'dataFimInscricao'=>NULL), array('atv'=>tipo_atividade::all()));
	}


	public function CadastraAtividade() {

		$botao=input::get('Cadastrar');
		$bHorario=input::get('cHorario');	
		$bCoordenador= input::get('CCoordenador');
		if(isset($botao)){
			
			$nome=Input::get('nome');
			$conteudo=Input::get('conteudo'); 
			$requisitos=Input::get('prequisitos');
			$preco=Input::get('Preco');
			$ambiente=Input::get('ambiente');
			$pacote=Input::get('Pacote');
			$horario=Input::get('horario');

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
			$end->endInfAdicionais=Input::get('adicional');

			$inicioIns=Input::get('iniIns');
			$fimIns=Input::get('fimIns');
			$numeroV=Input::get('NumeroVagas');
			$tipatv=Input::get('tpoAtividade');

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

			$query=Db::table('usuario_perfil_atividade')
			->join('atividade','upa_atiCod','=','atiCod')
			->where('upa_perCod',3)
			->where('upa_usuCod',session('id'))
			->where('ati_staCod',5)->get();

			$codAtv=$query[0]->atiCod;

			$codEndereco=$query[0]->ati_endCod;

			$query=DB::table('endereco')->max('endCod');
			$codEndereco=$query;

			$queryCoordenadores=User::all();
			$nomeCoordenadores=DB::table('users')
			->join('usuario_perfil_atividade','id','=','upa_usuCod')
			->where('upa_atiCod',$codAtv)
			->where('upa_perCod',3)->groupby('id')->get();
			

			$query=DB::table('atividade')
			->join('usuario_perfil_atividade','upa_atiCod','=','atiCod')
			->where('ati_staCod',5)
			->where('upa_usuCod',session('id'))->get(); 
			$codAtv=$query[0]->atiCod;

			$queryIns=DB::table('atividade')->where('atiCod',$codAtv)->update(['atiNome'=>$nome, 'atiPreco'=>$preco, 'atiCargaHoraria'=>$horario, 'atiNumVagas'=>$numeroV, 'atiConteudo'=>$conteudo, 'atiPreRequisito'=>$requisitos, 'atiNecessidadeMaterialAmbiente'=>$ambiente, 'atiDataIniInsc'=>$inicioIns, 'atiDataFimInsc'=>$fimIns, 'atiIncluidaPcteEvento'=>$pacote, 'ati_tipAtiCod'=>$tipatv, 'ati_endCod'=>$codEndereco, 'ati_staCod'=>6
				]); 

			$queryIns=Db::table('endereco')->where('endCod',$codEndereco)->update(['endRua'=>$end->endRua,'endEstado'=>$end->endEstado,'endCidade'=>$end->endCidade,'endBairro'=>$end->endBairro,'endCep'=>$end->endCEP,'endNumero'=>$end->endNumero,'endPais'=>$end->endPais,'endComplemento'=>$end->endComplemento, 'endInfAdicionais'=>$end->endInfAdicionais]);

			$this->VerificaCoordenador(); 


			$query=Atividade::find($codAtv);
			$end=Endereco::find($query->ati_endCod);

			session(['horario'=>horario_dia::all()]);
			return view('criaatividadehorario', array('per'=>session('perfis'), 'evento'=>NULL, 'mensagem'=>'', 'val'=>$query, 'total'=>$this->HorasTotais($codAtv), 'end'=>$end, 'coordenadores'=>$queryCoordenadores,'nomeCoordenadores'=>$nomeCoordenadores), array('atv'=>tipo_atividade::all()));




		}

		if(isset($bHorario)){

			$data=input::get('data');
			$horaF=input::get('Fim');
			$codAtv=input::get('Codigo');
			$dataA=date('Y-m-d', strToTime($data)); 
			$horaIni=input::get('Inicio');
			$timestampIni=$dataA.' '.$horaIni; 
			$timestampFim=$dataA.' '.$horaF;
			$dtFim=date('Y-m-d H:i:s', strtotime($timestampFim));
			$dtIni=date('Y-m-d H:i:s', strtotime($timestampIni));
			$total=$this->HorasTotais($codAtv);
			$query=Atividade::find($codAtv);
			$end=Endereco::find($query->ati_endCod);
			$QtdInserir=((strtotime($dtFim)-strtotime($dtIni))/60)/60;
			$restante=$query->atiCargaHoraria-$total; 



			if ($QtdInserir<=$restante){


				$query=atividade::find($codAtv);
				$total=$this->HorasTotais($codAtv);
				$inicioInscricao=$query->atiDataIniInsc;
				$fimInscricao=$query->atiDataFimInsc;


				$queryCoordenadores=User::all();
				$nomeCoordenadores=DB::table('users')
				->join('usuario_perfil_atividade','id','=','upa_usuCod')
				->where('upa_atiCod',$codAtv)
				->where('upa_perCod',3)->groupby('id')->get();




				if(($inicioInscricao<$dtIni && $fimInscricao<=$dtFim)){

					if(strtotime($dtFim)>strtotime($dtIni)){
						$horario = new horario_dia();
						$horario->horDataIniRealizacao=$dtIni;
						$horario->horDataFimRealizacao=$dtFim;
						$horario->hor_atiCod=$codAtv;
						$horario->save();
						


						$total=$this->HorasTotais($codAtv);
						if ($total<$query->atiCargaHoraria){
							session(['horario'=>horario_dia::all()]);  

							return view('criaatividadehorario', array('per'=>session('perfis'), 'evento'=>NULL, 'val'=>$query, 'total'=>$total, 'mensagem'=>'', 'end'=>$end, 'coordenadores'=>$queryCoordenadores,'nomeCoordenadores'=>$nomeCoordenadores), array('atv'=>tipo_atividade::all()));
                        //return view('horarioatividades',array('val'=>$query, 'total'=>$total, 'mensagem'=>''));
						}else {
							date_default_timezone_set('Brazil/East');
							date_default_timezone_set('America/Sao_Paulo');
							$dataAtual=date('Y-m-d H:i:s');
							$dataInscricoesIni=$query->atiDataIniInsc;
							$dataInscricoesFim=$query->atiDataFimInsc;
							if (($dataAtual>$dataInscricoesIni) and ($dataAtual<$dataInscricoesFim) ){
								Db::table('atividade')->where('atiCod',$codAtv)->update(['ati_staCod'=>8]);
							}else {
								Db::table('atividade')->where('atiCod',$codAtv)->update(['ati_staCod'=>7]);
							}

							return view('mensagens',array('mensagem'=>'Horarios cadastrados com sucesso !'));
						}
					}else{
						return view('criaatividadehorario', array('per'=>session('perfis'), 'evento'=>NULL, 'mensagem'=>'Hora Inicial deve ser menor que a final','end'=>$end, 'val'=>$query, 'total'=>$this->HorasTotais($codAtv), 'coordenadores'=>$queryCoordenadores,'nomeCoordenadores'=>$nomeCoordenadores ), array('atv'=>tipo_atividade::all()));
						
						

                    //return view('horarioatividades',array('val'=>$query, 'total'=>$total, 'mensagem'=>'Hora Inicial deve ser menor que a final'));
					}





				}else{
					$mens='Você está tentando cadastrar o horário antes ou no periodo de inscrições da atividade. Por favor, verifique os horários e cadastre após o periodo'; 
					return view('criaatividadehorario', array('per'=>session('perfis'), 'evento'=>NULL, 'mensagem'=>$mens, 'val'=>$query,'end'=>$end, 'total'=>$this->HorasTotais($codAtv), 'coordenadores'=>$queryCoordenadores,'nomeCoordenadores'=>$nomeCoordenadores), array('atv'=>tipo_atividade::all()));
				}


				
			}else{
				$mens='Você esta tentando cadastrar '.$QtdInserir.' hora(s) de curso. Você pode cadastrar '.$restante. ' hora (s) de curso'; 
				return view('criaatividadehorario', array('per'=>session('perfis'), 'evento'=>NULL, 'mensagem'=>$mens, 'val'=>$query,'end'=>$end, 'total'=>$this->HorasTotais($codAtv),'coordenadores'=>$queryCoordenadores,'nomeCoordenadores'=>$nomeCoordenadores), array('atv'=>tipo_atividade::all()));


                //return view('horarioatividades',array('val'=>$query, 'total'=>$total, 'mensagem'=>$mens));
			}
		}


		if(isset($bCoordenador)){
			$at=input::get('Atividade');
			$usuario=input::get('Cadidatos');
			$novoCoordenador=new usuario_perfil_atividade();
			$novoCoordenador->upa_atiCod=$at;
			$novoCoordenador->upa_usuCod=$usuario;
			$novoCoordenador->upa_perCod=3;
			$novoCoordenador->save();

			DB::table('inscricao')
			->where('ins_atiCod',$at)
			->where('ins_usuCod',$usuario)->delete();


			DB::table('usuario_perfil_atividade')
			->where('upa_usuCod',$usuario)
			->where('upa_atiCod',$at)
			->where('upa_perCod',1)->delete();

			return view('mensagens',array('mensagem'=>'Permissão de coordenador concedida com sucesso !'));

		}




	}

	public function VerificaCoordenador(){
		$perfil_Atv=db::table('atividade')
		->join('usuario_perfil_atividade','atiCod','=','upa_atiCod')
		->where('upa_usuCod',session('id'))
		->where ('ati_staCod',5)->get();

		$perfil_Eve=db::table('evento')
		->join('usuario_perfil_evento','eveCod','=','upe_eveCod')
		->where('upe_usuCod',session('id'))
		->where ('eve_staCod',5)->get();

		if (($perfil_Eve)&&($perfil_Atv)){
			session(['coordenadorPermissoes'=>3]); 
			//echo "3";
		}
		elseif($perfil_Atv){
			session(['coordenadorPermissoes'=>1]); 
			//echo "1";
		}
		elseif($perfil_Eve){
			session(['coordenadorPermissoes'=>2]); 
			//echo "2";
		}else{
			session(['coordenadorPermissoes'=>0]); 
			//echo "0";
		}
	}


	public function alteraDadosAtividade(){
		date_default_timezone_set('Brazil/East');
		date_default_timezone_set('America/Sao_Paulo');

		$botao=input::get('Cadastrar');
		if (isset($botao)) {

			$nome=Input::get('nome');
			$conteudo=Input::get('conteudo'); 
			$requisitos=Input::get('prequisitos');
			$preco=Input::get('Preco');
			$ambiente=Input::get('ambiente');
			$pacote=Input::get('Pacote');
			$horario=Input::get('horario');
		//Adicionando a captura do Código do evento

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
			$end->endInfAdicionais=Input::get('adicional');

			$inicioIns=Input::get('iniInsc');
			$fimIns=Input::get('fimIns');
			$numeroV=Input::get('NumeroVagas');
			$tipatv=Input::get('tpoAtividade');

			$atividade=input::get('Atividade');
			$ats=Atividade::find($atividade);
			$endder=$ats->ati_endCod;

			if($horario!=$ats->atiCargaHoraria){
				
				DB::table('atividade')->where('atiCod',$ats->atiCod)->update(['ati_staCod'=>6]);
			}
			
			$data=date('Y-m-d');

			
			if ($data<$fimIns){
				
				$queryIns=DB::table('atividade')->where('atiCod',$atividade)->update(['atiNome'=>$nome, 'atiPreco'=>$preco, 'atiCargaHoraria'=>$horario, 'atiNumVagas'=>$numeroV, 'atiConteudo'=>$conteudo, 'atiPreRequisito'=>$requisitos, 'atiNecessidadeMaterialAmbiente'=>$ambiente, 'atiDataIniInsc'=>$inicioIns, 'atiDataFimInsc'=>$fimIns, 'atiIncluidaPcteEvento'=>$pacote]); 


				$queryIns=Db::table('endereco')->where('endCod',$endder)->update(['endRua'=>$end->endRua,'endEstado'=>$end->endEstado,'endCidade'=>$end->endCidade,'endBairro'=>$end->endBairro,'endCep'=>$end->endCEP,'endNumero'=>$end->endNumero,'endPais'=>$end->endPais,'endComplemento'=>$end->endComplemento, 'endInfAdicionais'=>$end->endInfAdicionais]);

				return view('mensagens',array('mensagem'=>'Os dados da atividade foram alterados com sucesso !'));

			}else{
				return view('mensagens',array('mensagem'=>'A data final do periodo de inscrições deve ser maior que a data de hoje !'));
			}

			
		}
		

	}

	public function removeHorario(){
		$codigoHorario=input::get('codHorario');
		$codAtividade=input::get('codAtividade');
		DB::transaction(function() use($codAtividade,$codigoHorario){
			DB::table('horario_dia')->where('horCod',$codigoHorario)->delete();
			DB::table('atividade')->where('atiCod',$codAtividade)->update(['ati_staCod'=>6]);

		});

		$atividade=atividade::find($codAtividade);
		$endereco=endereco::find($atividade->ati_endCod);
		$query=DB::table('horario_dia')->where('hor_atiCod',$codAtividade)->get();
		$data=date('Y-m-d');


		$eventos=DB::table('evento')
		->join('atividade','ati_eveCod','<>','eveCod')
		->join('usuario_perfil_evento','eveCod','=','upe_eveCod')
		->where('upe_perCod',3)
		->where('upe_usuCod',$usuario)->groupby('eveCod')->get();

		if (!$eventos){
			$eventos=0;
		}

		$evr=0;
		if($atividade->ati_eveCod != NULL){
			$verif=0;
			$evr=Evento::find($atividade->ati_eveCod);
			$nomeEvento=$evr->eveNome;
		}else{
			$verif=1;
		}
		if($data<$atividade->atiDataIniInsc){
			$inscricao=1;
		}else{
			$inscricao=0;
		}

		return view('alteraInfAtividades',array('dados'=>$atividade, 'ende'=>$endereco,'hor'=>$query,'inscricao'=>$inscricao,'vinculo'=>$eventos, 'evento'=>$evr,'ver'=>$verif)); 

	}


	public function vinculoAtividade(){
		$cod=input::get('Codigo');
		$evento=input::get('Evento');

		$atv=Atividade::find($cod);
		$codEndereco=$atv->ati_endCod;






		DB::table('atividade')
		->where('atiCod',$cod)
		->update(['ati_eveCod'=>$evento]);

		$query=Evento::find($evento);

		$codEnderecoEvento=$query->eve_endCod;

		$end=Endereco::find($codEnderecoEvento);


		$incio=$query->atiDataIniInsc;
		$fim=$query->atiDataFimInsc;

		DB::table('atividade')
		->where('atiCod',$cod)
		->update(['atiDataIniInsc'=>$incio,'atiDataFimInsc'=>$fim]);


		$queryIns=Db::table('endereco')->where('endCod',$codEndereco)->update(['endRua'=>$end->endRua,'endEstado'=>$end->endEstado,'endCidade'=>$end->endCidade,'endBairro'=>$end->endBairro,'endCep'=>$end->endCEP,'endNumero'=>$end->endNumero,'endPais'=>$end->endPais,'endComplemento'=>$end->endComplemento, 'endInfAdicionais'=>$end->endInfAdicionais]);

		return view('mensagens',array('mensagem'=>'Atividade vinculada com sucesso!'));


	}


}
