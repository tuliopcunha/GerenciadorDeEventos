<?php

namespace App\Http\Controllers;

use DB; 
use Auth;
use App\perfil;

class SessionController extends Controller
{

  public static function seedSession(){
    $user = Auth::user();
    session(['id'=>$user->id,'name'=>$user->name,'usuInstituicaoVinculo'=>$user->usuInstituicaoVinculo,'perfilAtual'=>Perfil::find($user->usu_UltimoLog)->perDescricao,'perfis'=> SessionController::verificaPerfis($user),'coordenadorPermissoes'=> SessionController::verificaCoordenador($user)]);
  }


  private static function verificaPerfis($user){

    $perfil_Ati=DB::table('perfil')
    ->join('usuario_perfil_atividade','perCod','=','upa_perCod')
    ->where('upa_usuCod',$user->id)
    ->groupby('perCod')->get();

    $perfil_Eve=DB::table('perfil')
    ->join('usuario_perfil_evento','perCod','=','upe_perCod')
    ->where('upe_usuCod',$user->id)
    ->groupby('perCod')->get();

    $perfil[]=Perfil::find($user->usu_TipoPerfil)->perDescricao;

    $perfil[]='Participante';

    foreach ($perfil_Ati as $k ) {
      foreach ($perfil as $per){
        if ($per == $k->perDescricao){
          break;
        } else {
          $perfil[]=$k->perDescricao;
          break;
        }
      }
    }
    foreach ($perfil_Eve as $k ) {
      foreach ($perfil as $per){
        if ($per == $k->perDescricao){
          break;
        } else {
          $perfil[]=$k->perDescricao;
          break;
        }
      }
    }
    return array_unique($perfil);
  }

 private static function verificaCoordenador($user)
  {
    $perfil_Atv=DB::table('atividade')
    ->join('usuario_perfil_atividade','atiCod','=','upa_atiCod')
    ->where('upa_usuCod',$user->id)
    ->where ('ati_staCod',5)->get();

    $perfil_Eve=DB::table('evento')
    ->join('usuario_perfil_evento','eveCod','=','upe_eveCod')
    ->where('upe_usuCod',$user->id)
    ->where ('eve_staCod',5)->get();

    if (($perfil_Eve)&&($perfil_Atv)){
      return $coordenadorPermissoes=3; 
    }
    elseif($perfil_Atv){
      return $coordenadorPermissoes=1;
    }
    elseif($perfil_Eve){
      return $coordenadorPermissoes=2; 
    }else{
      return $coordenadorPermissoes=0;
    }
  }
}
