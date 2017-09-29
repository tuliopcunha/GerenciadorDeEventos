<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\atividade;
use App\endereco;
use App\frequencia;


class FrequenciaController extends MinhasAtividadesController
{

  public function FrequenciaAlunos(){
   $botaoSubmete=input::get('submete');
   $botao=input::get('Listar');
   if (isset($botaoSubmete)){


    $atividade=input::get('atv');
    $horario=input::get('horario');
    $query=DB::table('inscricao')->where('ins_atiCod',$atividade)->get();

    foreach ($query as $freque) {
      $freq=input::get($freque->insCod);


      $verifica_presenca=Db::table('frequencia')
      ->where('fre_horCod',$horario)
      ->where('fre_insCod',$freque->insCod)
      ->where('fre_atiCod',$atividade)->get();
      foreach ($verifica_presenca as $v_presenca) {
        if($v_presenca->fre_insCod==$freque->insCod && $v_presenca->fre_horCod==$horario && $v_presenca->fre_atiCod==$atividade){
         $query=DB::table('frequencia')->where('freCod',$v_presenca->freCod)->update(['freParticipacao'=>$freq]);
       }

     }

   }

   $query=atividade::find($atividade); 
   $endereco=Endereco::find($query->ati_endCod); 
   $horario_atividade=DB::table('horario_dia')
   ->where('hor_atiCod',$atividade)->get(); 

   $eve=0;

   if($query->ati_eveCod != NULL){
    $eve=Evento::find($query->ati_eveCod);
    $verif=0;
  } 
  else{
    $verif=1;
  }

  $inscritos=Db::table('users')
  ->join('inscricao','id','=','ins_usuCod')
  ->where('ins_atiCod',$atividade)->get(); 

  $queryCoordenadores=DB::table('users')
  ->join('usuario_perfil_atividade','id','=','upa_usuCod')
  ->where('upa_atiCod',$atividade)
  ->where('upa_perCod','<>',3)
  ->get();


  $nomeCoordenadores=DB::table('users')
  ->join('usuario_perfil_atividade','id','=','upa_usuCod')
  ->where('upa_atiCod',$atividade)
  ->where('upa_perCod',3)->get();

  return view('acompanharatividade', array('dados'=>$query, 'horario'=>$horario_atividade , 'inscritos'=>$inscritos,'alteracao'=>0,'ver'=>$verif,'evento'=>$eve, 'nomeCoordenadores'=>$nomeCoordenadores, 'coordenadores'=>$queryCoordenadores), array('ende'=>$endereco)); 


}




if(isset($botao)){


 $atividade=input::get('atv');
 $horario=input::get('horario');
 $query=atividade::find($atividade); 


 $endereco=Endereco::find($query->ati_endCod); 
 $horario_atividade=DB::table('horario_dia')->where('hor_atiCod',$atividade)->get();

 $inscritos=Db::table('users')->join('inscricao','id','=','ins_usuCod')->where('ins_atiCod',$atividade)->get(); 



 $listar=DB::table('inscricao')->where('ins_atiCod',$atividade)->get();

 foreach ($listar as $lst) {
  $verifica_presenca=DB::table('frequencia')
  ->where('fre_insCod',$lst->insCod)
  ->where('fre_atiCod',$lst->ins_atiCod)
  ->where('fre_horCod',$horario)->get();
  if(!$verifica_presenca){
   $freque=new frequencia(); 
   $freque->fre_horCod=$horario;
   $freque->fre_insCod=$lst->insCod;
                     $freque->freParticipacao=0;   //1 participou 0 não participou
                     $freque->fre_atiCod=$atividade;
                     $freque->save();
                   }
                 }

                 $Listar=DB::table('users')
                 ->join('inscricao','id','=','ins_usuCod')
                 ->join('frequencia','insCod','=','fre_insCod')
                 ->where('fre_atiCod',$atividade)
                 ->where('fre_horCod',$horario)
                 ->get();

                 return view('acompanharatividadepresenca', array('dados'=>$query, 'horario'=>$horario_atividade), array('ende'=>$endereco, 'inscritos'=>$Listar,'codHorario'=>$horario));
               }

             }


           }
