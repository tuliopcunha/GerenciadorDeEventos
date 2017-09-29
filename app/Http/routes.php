<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Autenticação
Route::auth();

	//Cidades e Estados
Route::get('/ufs/', function($uf = null){
	return response()->json(\App\cidade::select('uf')->distinct('uf')->orderBy('uf')->get());
});
Route::get('/cidades/{uf}', function($uf = null){
	return response()->json(\App\cidade::where('uf', $uf)->orderBy('nome')->get());
});

// Registro
Route::get('/confirmacao','Auth\AuthController@emailEnviado');
Route::get('/confirmacao/registrar/{id}/{email}','Auth\AuthController@confirmaCadastro');
Route::post('/confirmacao/info','Auth\AuthController@registrarDados');

// Esqueci Meu Email
Route::get('/esquecimeuemail','Auth\AuthController@getEsqueciEmail');
Route::post('/esquecimeuemail','Auth\AuthController@postEsqueciEmail');

//Grupo de Autenticados
Route::group(['middleware' => 'auth'], function() {
	
// Home
	Route::get('/', 'HomeController@index');
	Route::get('/home', 'HomeController@index');

// PDF
	Route::post('/pdf', 'PdfController@invoice'); 

// Atividades

	route::post('/atividades/minhas_atividades/informacoes/alterainformacoes/vinculo','AtividadesController@vinculoAtividade');
	Route::post('/atividades/minhas_atividades/informacoes/alterainformacoes/removeHorario','AtividadesController@removeHorario');
	Route::post('/atividades/minhas_atividades/informacoes/alterainformacoes/alterado','AtividadesController@alteraDadosAtividade');
	Route::post('/CadastraAtividade','AtividadesController@CadastraAtividade');
	Route::post('/atividades/minhas_atividades/informacoes/listapresenca','FrequenciaController@FrequenciaAlunos');
	Route::post('/atividades/minhas_atividades/informacoes/alterainformacoes','MinhasAtividadesController@redirecAlteraInformacoesAtividade');
	Route::post('/atividades/atividades_disponiveis/mais_informacoes','MinhasAtividadesController@redirecInformacoes');
	Route::post('/Inscreve','InscricoesController@ParticipaAtividade');
	Route::post('/atividades/minhas_atividades/informacoes','MinhasAtividadesController@redirecAtvHorario');
	Route::post('/atividades/cadastro_horarios','MinhasAtividadesController@cadastraHorario'); 
	Route::post('/altera_perfil', 'PerfilUsuarioController@AlteraPerfil');
	Route::post('/CadastraAtividade','AtividadesController@CadastraAtividade');
	Route::get('/atividades/inscricoes','MinhasAtividadesController@redirecAtvInscritas');
	Route::get('/atividades/atividades_disponiveis','MinhasAtividadesController@RedirectAtvDisponiveis');
	Route::get('/atividades/minhas_atividades', 'MinhasAtividadesController@redirecMAtividadesCoordenador');
	Route::get('/atividade/criar_atividade','AtividadesController@redirecCriaAtividade');
	Route::post('/atividades/minhas_atividades/informacoes/adiciona_coordenador','MinhasAtividadesController@adicionaCoordenadorAtividade');

// Eventos
	Route::post('/eventos/cadastraEvento','EventosController@cadastraEvento');
	Route::post('/eventos/pagina_do_evento', 'MeusEventosController@redirecPaginaEvento');
	Route::post('/eventos/cria_atividade', 'MeusEventosController@redirecCriarAtividadeRelacionadaEvento');
	Route::get('/eventos/criarEvento','EventosController@redirecCriaEvento');
	Route::get('/eventos/inscritos', 'MeusEventosController@redirecEveInscritos');
	Route::get('/eventos/meus_eventos', 'MeusEventosController@redirecMeusEventos');
	Route::get('/eventos/disponiveis', 'MeusEventosController@RedirectEveDisponiveis');
	Route::post('/eventos/{nomeDoEvento}/{codigoDoEvento}/inscrever_se', ['uses' =>'InscricoesController@inscreverEvento']);
	Route::post('/eventos/{nomeDoEvento}/{codigoDoEvento}/selecionar_coordenador', ['uses' =>'EventosController@redirectAdicionarCoordenadorEvento']);
	Route::post('/eventos/{nomeDoEvento}/{codigoDoEvento}/adicionar_coordenador', ['uses' =>'EventosController@adicionarCoordenadorEvento']);
	Route::post('/eventos/{nomeDoEvento}/{codigoDoEvento}/inscrever_se/exclusivo', ['uses' =>'MeusEventosController@redirecInscricaoEventoExclusivo']);
	Route::get('/eventos/{nomeDoEvento}/{codigoDoEvento}/editar_evento', ['uses' =>'MeusEventosController@redirecAlteraInformacoesEvento']);
	Route::post('/eventos/{nomeDoEvento}/{codigoDoEvento}/editar_evento/confirmacao', ['uses' =>'EventosController@editaEvento']);
	Route::get('/eventos/{nomeDoEvento}/{codigoDoEvento}', ['as'=> 'paginaDoEvento', 'uses' =>'MeusEventosController@redirecPaginaEvento']);
	
// Permissões
	Route::post('/permissoes/confirma_dados/permissao_concedida','PermissoesUsuarioController@ConcedePermissoesAtiv');
	Route::post('/permissoes/confirma_dados','PermissoesUsuarioController@btnOK');
	Route::get('/permissoes/atividade','PermissoesUsuarioController@redirecAtividade');
	Route::get('/permissoes/evento','PermissoesUsuarioController@redirecEvento');

// Perfil
	Route::post('/altera_perfil', 'PerfilUsuarioController@alteraPerfil');
	Route::post('/meu_perfil', 'PerfilUsuarioController@alteraDados');
	Route::post('/alterarsenha', 'PerfilUsuarioController@alteraSenha');
	Route::get('/meu_perfil', 'PerfilUsuarioController@retornaDados');

// Contato
	Route::post('/contato/','ContatoController@criaContato');
	Route::get('/contato/{pagina}','ContatoController@index');
	Route::get('/contato','ContatoController@indexHome');

// Sobre
	Route::get('/sobre','HomeController@retornaSobre');
});























