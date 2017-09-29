<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\atividade;
use App\endereco; 
use App\evento;
use App\User;
use App\horario_dia; 
use App\tipo_atividade; 
use App\usuario_perfil_atividade;
use DB;


class MinhasAtividadesController extends Controller 
{

    public function redirecAtvInscritas(){
        date_default_timezone_set('Brazil/East');
        date_default_timezone_set('America/Sao_Paulo');
        $data = date('Y-m-d H:i:s'); 
        $atividades=array(); 
        $i=0; 
        $query=Db::table('atividade')
        ->join('inscricao','atiCod','=','ins_atiCod')
        ->join('horario_dia','atiCod','=','hor_atiCod')
        ->where('ins_usuCod',session('id'))
        ->where ('horDataFimRealizacao','>=',$data)->groupby('atiCod')->get();

        $horario=horario_dia::all(); 
        return view('atividadesinscritas',array('ativi'=>$query, 'horario'=>$horario)); 

    }

    public function redirecInformacoes(){
        date_default_timezone_set('Brazil/East');
        date_default_timezone_set('America/Sao_Paulo');
        $dataa = date('Y-m-d H:i:s'); 
        $atividades=array(); 
        $i=0; 
        $consulta=Db::table('atividade')
        ->join('inscricao','atiCod','=','ins_atiCod')
        ->join('horario_dia','atiCod','=','hor_atiCod')
        ->where('ins_usuCod',session('id'))
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
            $inscrito=1;    

            if(($atividade->ati_eveCod <> NULL) && ($atividade->atiIncluidaPcteEvento == 'Sim')){

                $eventoDaAtividade = DB::table('evento')
                ->where('eveCod',$atividade->ati_eveCod)
                ->get();
                $eventoDaAtividade = $eventoDaAtividade[0];
                
                if($eventoDaAtividade->eve_tieCod == 1){

                    $eventosInscritos = app('App\Http\Controllers\MeusEventosController')->verificaEventosInscritosPeloUsuario();  

                    if(in_array($eventoDaAtividade, $eventosInscritos)){
                        $inscrito = 3;
                    }else{
                        $inscrito = 1;
                    }
                }

            }

            return view ('maisinformacoes',array('dados'=>$atividade, 'ende'=>$endereco, 'hor'=>$horario, 'inscrito'=>$inscrito, 'mensagem'=>'Não possui informação', 'evento'=>$eve,'ver'=>$verif));
        }else{
           return view ('maisinformacoes',array('dados'=>$atividade, 'ende'=>$endereco, 'hor'=>$horario, 'inscrito'=>2, 'mensagem'=>'Não possui informação', 'evento'=>$eve,'ver'=>$verif));
       }

   }

   public function RedirectAtvDisponiveis() {
    $this->VerificaAtividades();
    date_default_timezone_set('Brazil/East');
    date_default_timezone_set('America/Sao_Paulo');
    $data = date('Y-m-d H:i:s'); 
    $query = DB::table('atividade')
    ->join('usuario_perfil_atividade','atiCod','=','upa_atiCod')
    ->where('atiDataIniInsc','<=',$data)
    ->where('atiDataFimInsc','>=',$data)
    ->where('ati_eveCod',NULL)
    ->where('ati_staCod',8)->groupby('atiCod')
    ->get(); 
    $ati=array();
    $queryInscricoes= DB::table('inscricao')
    ->where('ins_usuCod',session('id'))->get();
    $i=0; 
    if(!$queryInscricoes){
        $ati=$query; 
    }else{
        foreach ($query as $rowAtv) {
            foreach ($queryInscricoes as $rowInsc) {
                if($rowAtv->atiCod<>$rowInsc->ins_atiCod){
                    $val=1; 
                }else{
                    $val=2;
                    break; 
                }
            }
            if ($val==1){ 
                $i++;
                $ati[$i]=$rowAtv; 

            }
        }
    }



    $query=Db::table('atividade')
    ->join('inscricao','atiCod','=','ins_atiCod')
    ->join('horario_dia','atiCod','=','hor_atiCod')
    ->where('ins_usuCod',session('id'))->get();
    $query=horario_dia::all(); 
    return view('atividadesdisponiveis', array('ativi'=>$ati,'horario'=>$query,'quatidade'));
}


public function redirecMAtividadesCoordenador() {

 $query=DB::table('atividade')
 ->join('usuario_perfil_atividade','atiCod','=','upa_atiCod')
 ->where('upa_usuCod',session('id'))
 ->where('upa_perCod',3)->get(); 
 $v=array();
 foreach ($query as $k) {
  $queryins=DB::table('usuario_perfil_atividade')
  ->where('upa_perCod',1)
  ->where('upa_atiCod',$k->atiCod)->count(); 
  $v[$k->atiCod]=$queryins; 
  date_default_timezone_set('Brazil/East');
  date_default_timezone_set('America/Sao_Paulo');
  $dataAtual=date('Y-m-d H:i:s');
  $dataInscricoesIni=$k->atiDataIniInsc;
  $dataInscricoesFim=$k->atiDataFimInsc;


  if (($dataAtual>=$dataInscricoesIni) and ($dataAtual<=$dataInscricoesFim) ){

    if($k->ati_staCod<>6 and $k->ati_staCod<>5 ){
        Db::table('atividade')->where('atiCod',$k->atiCod)->update(['ati_staCod'=>8]);
    }

}else if(($dataAtual<$dataInscricoesIni) and ($dataAtual<$dataInscricoesFim)) {
    if($k->ati_staCod<>6 and $k->ati_staCod<>5 ){
        Db::table('atividade')->where('atiCod',$k->atiCod)->update(['ati_staCod'=>7]);
    }
    

} else if (($dataAtual>$dataInscricoesIni) and ($dataAtual>$dataInscricoesFim)) {
    if($k->ati_staCod<>6 and $k->ati_staCod<>5 ){
        Db::table('atividade')->where('atiCod',$k->atiCod)->update(['ati_staCod'=>9]);
    }
}



}

$query=DB::table('atividade')
->join('usuario_perfil_atividade','atiCod','=','upa_atiCod')
->where('upa_usuCod',session('id'))
->where('upa_perCod',3)->get(); 



$this->VerificaAtividades();
$horario=horario_dia::all();
return view('minhasatividades', array('inscritos'=>$v),array('ativi'=>$query, 'horario'=>$horario));
}

public function redirecAtvHorario() {

    $botaoOK=input::get('Status');
    $atv=input::get('Codigo');
    $query="";
    $query=atividade::find($atv);
    $end=Endereco::find($query->ati_endCod);
    $horario=DB::table('horario_dia')
    ->where('hor_atiCod',$atv)->get(); 

    $inscritos=Db::table('users')
    ->join('inscricao','id','=','ins_usuCod')
    ->where('ins_atiCod',$atv)->get(); 

    date_default_timezone_set('Brazil/East');
    date_default_timezone_set('America/Sao_Paulo');
    $data = date('Y-m-d H:i:s');
    $consultaAlteracaoAtv=DB::table('atividade')
    ->where('atiDataIniInsc','<',$data)
    ->where('atiCod',$atv)->get(); 
    $eve=0;

    if($query->ati_eveCod != NULL){
        $eve=Evento::find($query->ati_eveCod);
        $verif=0;
    } 
    else{
        $verif=1;
    }

    $queryCoordenadores=User::all();
    $nomeCoordenadores=DB::table('users')
    ->join('usuario_perfil_atividade','id','=','upa_usuCod')
    ->where('upa_atiCod',$atv)
    ->where('upa_perCod',3)->groupby('id')->get();


   //dd($queryCoordenadores);

    if($consultaAlteracaoAtv){
        $alteracao=0;
    }else{
        $alteracao=1;
    }


    if ($botaoOK==6){
        $total=$this->HorasTotais($atv); 
        if ($total<$query->atiCargaHoraria){
            session(['horario'=>horario_dia::all()]);
            return view('criaatividadehorario', array('per'=>session('perfis'), 'evento'=>NULL, 'mensagem'=>'', 'val'=>$query, 'total'=>$this->HorasTotais($atv), 'end'=>$end, 'coordenadores'=>$queryCoordenadores,'nomeCoordenadores'=>$nomeCoordenadores), array('atv'=>tipo_atividade::all()));
            //return view('horarioatividades',array('val'=>$query, 'total'=>$total, 'mensagem'=>''));
        }else {
            date_default_timezone_set('Brazil/East');
            date_default_timezone_set('America/Sao_Paulo');
            $dataAtual=date('Y-m-d H:i:s');
            $dataInscricoesIni=$query->atiDataIniInsc;
            $dataInscricoesFim=$query->atiDataFimInsc;
            if (($dataAtual>=$dataInscricoesIni) and ($dataAtual<=$dataInscricoesFim) ){

                if($query->ati_stacod<>6 and $query->ati_stacod<>5 ){
                    Db::table('atividade')->where('atiCod',$atv)->update(['ati_staCod'=>8]);
                }

            }else if(($dataAtual<$dataInscricoesIni) and ($dataAtual<$dataInscricoesFim)) {
                if($query->ati_stacod<>6 and $query->ati_stacod<>5 ){
                    Db::table('atividade')->where('atiCod',$atv)->update(['ati_staCod'=>7]);
                }
                

            } else if (($dataAtual>$dataInscricoesIni) and ($dataAtual>$dataInscricoesFim)) {
                if($query->ati_stacod<>6 and $query->ati_stacod<>5 ){
                    Db::table('atividade')->where('atiCod',$atv)->update(['ati_staCod'=>9]);
                }
            }

            return view('acompanharatividade', array('dados'=>$query, 'horario'=>$horario, 'inscritos'=>$inscritos, 'alteracao'=>$alteracao, 'evento'=>$eve, 'ver'=>$verif,'coordenadores'=>$queryCoordenadores,'nomeCoordenadores'=>$nomeCoordenadores), array('ende'=>$end)); 




            
        }
    }else if($botaoOK==8){                   
        return view('acompanharatividade', array('dados'=>$query, 'horario'=>$horario, 'inscritos'=>$inscritos, 'alteracao'=>$alteracao, 'evento'=>$eve, 'ver'=>$verif,'coordenadores'=>$queryCoordenadores,'nomeCoordenadores'=>$nomeCoordenadores), array('ende'=>$end)); 
    }


}

public function redirecAlteraInformacoesAtividade(){
    $usuario=session('id');
    $cod=input::get('Cod');
    $atividade=atividade::find($cod);
    $endereco=endereco::find($atividade->ati_endCod);
    $query=DB::table('horario_dia')->where('hor_atiCod',$cod)->get();


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

    $data=date('Y-m-d');

       /* $horarios=DB::table('atividade')
                ->join('horario_dia','atiCod','=','hor_atiCod')
                ->where('atiCod',$cod)->get();*/

                if($data<$atividade->atiDataIniInsc){
                    $inscricao=1;
                }else{
                    $inscricao=0;
                }
                
                return view('alterainfatividades',array('dados'=>$atividade, 'ende'=>$endereco,'hor'=>$query,'inscricao'=>$inscricao,'vinculo'=>$eventos, 'evento'=>$evr,'ver'=>$verif)); 
            }

            public function HorasTotais($atv) {
                $horasCadastradas=DB::table('atividade')
                ->join('horario_dia','atiCod','=', 'hor_atiCod')
                ->where('atiCod',$atv)->get(); 
                session(['horasCadastradas'=>$horasCadastradas]);

                if($horasCadastradas){
                    $total=0; 
                    foreach ($horasCadastradas as $hras) {
                        $horaInicio=$hras->horDataIniRealizacao;
                        $horaIni = substr($horaInicio, 11, 8); 
                        $horaFim = $hras->horDataFimRealizacao;
                        $horaF= substr($horaFim, 11, 8); 
                        $horaTotal=(((StrToTime($horaF))-(StrToTime($horaIni)))/60)/60;
                        $total=$total+$horaTotal; 
                    }
                }else{
                    $total=0;
                }
                return $total; 
            }

            public function cadastraHorario() {

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
                $queryCoordenadores=User::all();
                $nomeCoordenadores=DB::table('users')
                ->join('usuario_perfil_atividade','id','=','upa_usuCod')
                ->where('upa_atiCod',$codAtv)
                ->where('upa_perCod',3)->groupby('id')->get();

                if ($QtdInserir<=$restante){
                    if(strtotime($dtFim)>strtotime($dtIni)){
                       $horario = new horario_dia();
                       $horario->horDataIniRealizacao=$dtIni;
                       $horario->horDataFimRealizacao=$dtFim;
                       $horario->hor_atiCod=$codAtv;
                       $horario->save();
                       $query=atividade::find($codAtv);
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
                        if (($dataAtual>=$dataInscricoesIni) and ($dataAtual<=$dataInscricoesFim) ){
                            
                            Db::table('atividade')->where('atiCod',$atv)->update(['ati_staCod'=>8]);

                        }else if(($dataAtual<$dataInscricoesIni) and ($dataAtual<$dataInscricoesFim)) {
                            
                            Db::table('atividade')->where('atiCod',$atv)->update(['ati_staCod'=>7]);
                            
                            

                        }


                        return view('mensagens',array('mensagem'=>'Horarios cadastrados com sucesso !'));
                    }
                }else{
                    return view('criaatividadeHorario', array('per'=>session('perfis'), 'evento'=>NULL, 'mensagem'=>'Hora Inicial deve ser menor que a final','end'=>$end, 'val'=>$query, 'total'=>$this->HorasTotais($codAtv), 'coordenadores'=>$queryCoordenadores,'nomeCoordenadores'=>$nomeCoordenadores), array('atv'=>tipo_atividade::all()));
                    
                    

                    //return view('horarioatividades',array('val'=>$query, 'total'=>$total, 'mensagem'=>'Hora Inicial deve ser menor que a final'));
                }
            }else{
                $mens='Você esta tentando cadastrar '.$QtdInserir.' hora(s) de curso. Você pode cadastrar '.$restante. ' hora (s) de curso'; 
                return view('criaatividadehorario', array('per'=>session('perfis'), 'evento'=>NULL, 'mensagem'=>$mens, 'val'=>$query,'end'=>$end, 'total'=>$this->HorasTotais($codAtv), 'coordenadores'=>$queryCoordenadores,'nomeCoordenadores'=>$nomeCoordenadores), array('atv'=>tipo_atividade::all()));


                //return view('horarioatividades',array('val'=>$query, 'total'=>$total, 'mensagem'=>$mens));
            }
        }



        public function VerificaAtividades(){
            date_default_timezone_set('Brazil/East');
            date_default_timezone_set('America/Sao_Paulo');
            $data = date('Y-m-d H:i:s');


            $query=DB::table('atividade')
            ->orwhere('ati_staCod',7)
            ->orwhere('ati_staCod',8)
            ->orwhere('ati_staCod',9)
            ->get();


            foreach ($query as $atv) {

                $dataInico=$atv->atiDataIniInsc;
                $datafim=$atv->atiDataFimInsc;
                if($data<$dataInico){
                    DB::table('atividade')->where('atiCod',$atv->atiCod)->update(['ati_stacod'=>7]);
                    //return;
                }else if($data<=$datafim && $data>=$dataInico){
                    DB::table('atividade')->where('atiCod',$atv->atiCod)->update(['ati_stacod'=>8]);
                    //return;
                }else if($data>$datafim){
                    DB::table('atividade')->where('atiCod',$atv->atiCod)->update(['ati_stacod'=>9]);
                    //return;
                }
            }

        }


        public function adicionaCoordenadorAtividade(){
            $botao=input::get('CCoordenador');

            $at=input::get('Atividade');
            $usuario=input::get('Cadidatos');
            if (isset($botao)){
                echo "djfhef";
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

    }
