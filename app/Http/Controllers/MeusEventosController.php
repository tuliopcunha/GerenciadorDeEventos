<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\evento;
use App\atividade;
use App\usuario_perfil_atividade;
use App\tipo_atividade;
use DB;


class MeusEventosController extends Controller
{

public function contaNumeroInscritos($codigoEvento){

    $numeroInscritos=Db::table('atividade')
    ->join('inscricao','atiCod','=','ins_atiCod')
    ->where('ati_eveCod',$codigoEvento)->count();
    return $numeroInscritos;
}

public function verificaEventosInscritosPeloUsuario(){
    date_default_timezone_set('Brazil/East');
    date_default_timezone_set('America/Sao_Paulo');
    $data = date('Y-m-d H:i:s'); 
    $cod=session('id');

        // Busca Eventos onde o Usuario está Inscrito
            // Primeiro Se Encontra as Atividades Inscritas pelo usuario
    $atividadesInscritas=Db::table('atividade')
    ->join('inscricao','atiCod','=','ins_atiCod')
    ->join('horario_dia','atiCod','=','hor_atiCod')
    ->where('ins_usuCod','=',$cod)
    ->where ('horDataFimRealizacao','>=',$data)
    ->get();  

    $eventosInscritos = array();        
    $eventoPertencente = array();

            // Agora se associa as atividades encontradas com seus respectivos eventos
    foreach ($atividadesInscritas as $atividade) {
        $eventoPertencente=DB::table('evento')
        ->where('eveCod','=',$atividade->ati_eveCod)
        ->get();    
        if(in_array($eventoPertencente[0], $eventosInscritos))
            continue;
        else
            array_push($eventosInscritos, $eventoPertencente[0]);

    }

    return $eventosInscritos;
}

public function redirecEveInscritos(){
    session_start(); 

    $eventosInscritos = $this->verificaEventosInscritosPeloUsuario();


    return view('eventosinscritos',array('eventosInscritos'=>$eventosInscritos));  
}

public function RedirectEveDisponiveis() {
    session_start();
    date_default_timezone_set('Brazil/East');
    date_default_timezone_set('America/Sao_Paulo');
    $data = date('Y-m-d H:i:s'); 
    $cod=session('id');

        // Encontrando Eventos Com Data Final de Inscrição Superior a Data Atual
    $eventosDisponiveisInscricao = DB::table('evento')
    ->where('eveDataIniInsc','<=',$data)
    ->where('eveDataFimInsc','>=',$data)
    ->get();

    $eventosInscritos = $this->verificaEventosInscritosPeloUsuario();
    $eventosDisponiveis = array();
    $flag = 2;


    if(sizeof($eventosInscritos) == 0){
        $eventosDisponiveis = $eventosDisponiveisInscricao;
        return view('eventosdisponiveis',array('eventosDisponiveis'=>$eventosDisponiveis));
    }else{    
        foreach($eventosDisponiveisInscricao as $eD) {
           if(in_array($eD, $eventosInscritos))
             continue;
         else
             array_push($eventosDisponiveis, $eD);      
     }
     return view('eventosdisponiveis',array('eventosDisponiveis'=>$eventosDisponiveis));
 }    
}


public function redirecMeusEventos() {
    session_start();;
    $cod=session('id'); 
    $data = date('Y-m-d H:i:s'); 

    $eventosCoordenados=Db::table('evento')
    ->join('usuario_perfil_evento','eveCod','=','upe_eveCod')
    ->where('upe_usuCod',$cod)
    ->get();                             

    return view('meuseventos', array('eventos'=>$eventosCoordenados));
    session_commit();
}


public function redirecCriarAtividadeRelacionadaEvento() {

        $codigoEvento=Input::get('codigo');       
        $cod=session('id'); 
            // Dá a permissão criando uma atividade para o usuario
        $atividade= new atividade();
        $atividade->atiNome="Temporario";
        $atividade->ati_tipAtiCod=1;
        $atividade->ati_staCod=5;
        $atividade->ati_eveCod=$codigoEvento;
        $atividade->save();
        $query=DB::table('atividade')->max('atiCod');
        $codAtividade=$query;
        $usuAtividade= new usuario_perfil_atividade();
        $usuAtividade->upa_atiCod=$codAtividade;
        $usuAtividade->upa_usuCod=$cod;
        $usuAtividade->upa_perCod=3;
        $usuAtividade->save();

        $query=DB::table('endereco')
            ->join('evento','endCod','=','eve_endCod')
            ->where('eveCod',$codigoEvento)
            ->get();
        $enderecoEvento = $query[0];
        
        $query=DB::table('evento')
            ->where('eveCod',$codigoEvento)
            ->get();
        $meuEvento = $query[0];   
        return view('criaatividade', array('per'=>session('perfis'), 'evento'=>"yes", 'enderecoEvento'=>$enderecoEvento, 'dataIniInscricao'=>$meuEvento->eveDataIniInsc ,'dataFimInscricao'=>$meuEvento->eveDataFimInsc), array('atv'=>tipo_atividade::all()));

}

public function redirecEveHorario() {

    return view('acompanharevento', array()); 
}


public function redirecPaginaEvento($nomeDoEvento, $codigoEvento) {
    session_start();
    if ($_SESSION['loged']=1){
        $meuEvento = new evento();

        $cod=session('id');

            //Pegando dados do Evento
        $query=Db::table('evento')
        ->where('eveCod','=',$codigoEvento)
        ->get(); 

        if(sizeof($query) <> 0){ 
            $meuEvento = $query[0];
        }

        if(($nomeDoEvento == $meuEvento->eveNome) ){ 

                //Pegando numero de Inscritos
            $numeroInscritos = $this->contaNumeroInscritos($codigoEvento);

                //Pegando Dados Sobre enedereço
            $query=Db::table('evento')
            ->join('endereco','eve_endCod','=','endCod')->get();
            $endereco = $query[0];

                //Pegando todas atividades com relação ao evento
            $query=Db::table('atividade')
            ->where('ati_eveCod','=',$codigoEvento)
            ->get();

            $atividadesDoEvento = $query;  

                //PEgando endereço do Evento
            $enderecoEvento=DB::table('endereco')
            ->join('evento','endCod','=','eve_endCod')
            ->where('eveCod',$codigoEvento)
            ->get(); 
            $enderecoEvento = $enderecoEvento[0];            


                //Pegando os horarios das atividades do Evento
            $horario=Db::table('atividade')
            ->join('horario_dia','atiCod','=','hor_atiCod')
            ->where('ati_eveCod',$codigoEvento)
            ->get();


            date_default_timezone_set('Brazil/East');
            date_default_timezone_set('America/Sao_Paulo');
            $dataHoje = date('Y-m-d H:i:s');      



            $dataFimEvento = $dataHoje;
            $dataInicioEvento = $dataHoje * 3600*3600;

            foreach ($horario as $h) {
                if($h->horDataIniRealizacao < $dataInicioEvento)
                    $dataInicioEvento = $h->horDataIniRealizacao;

                if($h->horDataFimRealizacao > $dataFimEvento)
                    $dataFimEvento = $h->horDataFimRealizacao;
            }


                //Verifica se o Usuario da Pagina esta inscrito no atual evento
            $inscrito = $this->verificaEventosInscritosPeloUsuario();

            if(in_array($meuEvento, $inscrito))
                $inscrito = true;
            else
                $inscrito = false;    


            return view('paginadoevento', array('per'=>session('perfil'), 'meuEvento'=>$meuEvento, 'inscritos'=>$numeroInscritos, 'endereco'=>$enderecoEvento, 'codUsuario'=>$cod, 'atividades'=>$atividadesDoEvento, 'horario'=>$horario, 'inscrito'=>$inscrito, 'dataInicio'=>$dataInicioEvento,'dataFim'=>$dataFimEvento, 'dataHoje'=>$dataHoje));
        }else{
            return view('mensagens', array('mensagem'=>'<h1> Evento Não Encontrado </h1> <br> Clique no botão para Voltar para a página de seus eventos ou ir para o início <br> <br>
                <a href="/eventos/inscritos" name="Principal" class="btn btn-primary">Voltar Ao Seus Eventos</a> <br>
                ', 'retorno'=>'/eventos/inscritos'));
        }
    }
    else {
        echo "Você não está logado";
    }
    session_commit();

}

public function redirecAlteraInformacoesEvento($nomeDoEvento,$codigoEvento){
    $cod=input::get('Codigo');

    $evento=DB::table('evento')
    ->where('eveCod',$codigoEvento)
    ->get();
    $evento = $evento[0];    

    $endereco=DB::table('endereco')
    ->join('evento','endCod','=','eve_endCod')
    ->where('eveCod',$codigoEvento)
    ->get();
    $endereco = $endereco[0];

    $query=DB::table('usuario_perfil_evento')
    ->join('users','upe_usuCod','=','id')
    ->where('upe_eveCod',$codigoEvento)
    ->where('upe_perCod',3)
    ->get();
    $coordenadores = $query;    

    foreach ($coordenadores as $usuCod) {
        if(session('id') == $usuCod->id){
            $data=date('Y-m-d');

            if($data < $evento->eveDataIniInsc){
                $inscricao=1;
            }else{
                $inscricao=0;
            }

            return view('alterainfeventos',array('meuEvento'=>$evento, 'coordenadores'=>$coordenadores,'ende'=>$endereco, 'inscricao'=>$inscricao)); 
        }

    }
    return view('/eventos/{{$evento->eveNome}}/{{$evento->eveCod}}'); 

}

public function redirecInscricaoEventoExclusivo($nomeDoEvento,$codigoEvento){

    $usuario = session('id');

    $query=DB::table('inscricao')
    ->where('ins_usuCod',$usuario)
    ->get();
    $isncricoes=$query;  

    $query=DB::table('atividade')
    ->where('ati_eveCod','=',$codigoDoEvento)
    ->where('atiIncluidaPcteEvento','=','Sim')
    ->get();
    $atividadesDoPacoteEvento=$query;

    $atividadeInscrita = 0;                
    foreach ($atividadesDoPacoteEvento as $atividade) {
        foreach ($inscricoes as $inscricao) {
            if($inscricao->ins_atiCod == $atividade->atiCod){
                $atividadeInscrita = $inscricao->insCod;
                break;
            }
        }
    }

    $query=DB::table('inscricao')
    ->where('insCod',$atividadeInscrita)
    ->delete();

    return view('inscricaoevento', array('atividadesDoPacoteEvento'=>$atividadesDoPacoteEvento));                
}

}

