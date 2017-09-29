<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use App\atividade;
use App\horario_dia; 
use App\User;
use DB;

class PdfController extends Controller
{
    public function invoice() 
    {
        $clique=input::get('Gerar');
        if (isset($clique)){

            $codData=input::get('horario');
            $codAtv=input::get('atividade');
            $datas=horario_dia::find($codData);

            $alunos=DB::table('atividade')
            ->join('inscricao','atiCod','=','ins_atiCod')
            ->join('horario_dia','atiCod','=','hor_atiCod')
            ->join('users','ins_usuCod','=','id')
            ->where('hor_atiCod',$codAtv)->groupby('id')->get();


            date_default_timezone_set('Brazil/East');
            date_default_timezone_set('America/Sao_Paulo');
            $ativi=atividade::find($codAtv); 
            $coordenador=User::find(session('id'));
            $date = date('d/m/d H:i:s');
            $invoice = "2222";
            $view =  \View::make('invoice', compact('alunos', 'date', 'ativi','dados','datas','coordenador'))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view);
            
            return $pdf->download('ListaPresenca.pdf');

        }
        
    }

}