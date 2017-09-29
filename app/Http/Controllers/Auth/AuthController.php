<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SessionController;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
use Hash;
use Mail;
use App\area_conhecimento;
use App\User;
use App\titulo;
use App\perfil;
use App\endereco;
use App\formacaoacademica;

class AuthController extends Controller
{

	use AuthenticatesAndRegistersUsers, ThrottlesLogins;

	// Redirecionamento
	protected $redirectTo = '/';

	// Construtor
	public function __construct()
	{
		$this->middleware($this->guestMiddleware(), ['except' => 'logout']);
	}

	// Loga o usuário
	public function login(Request $request)
	{
		
		$this->validateLogin($request);

		$status=DB::table('users')
		->where('email','=',$request->email)
		->value('usu_staCod');
		if($status!=2 && $status!=null){
			return view('auth.emailenviado')->with('email',$request->email);
		} 

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
		$throttles = $this->isUsingThrottlesLoginsTrait();

		if ($throttles && $lockedOut = $this->hasTooManyLoginAttempts($request)) {
			$this->fireLockoutEvent($request);

			return $this->sendLockoutResponse($request);
		}

		$credentials = $this->getCredentials($request);

		if (Auth::guard($this->getGuard())->attempt($credentials, $request->has('remember'))) {
			return $this->handleUserWasAuthenticated($request, $throttles);
		} else {
			session(['errorlogin'=>'error']);
		}

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
		if ($throttles && ! $lockedOut) {
			$this->incrementLoginAttempts($request);
		}

		return $this->sendFailedLoginResponse($request);
		
	}

// Validação do Login
	protected function validateLogin(Request $request){
		if(!session('errorlogin')){
			$this->validate($request, [
				$this->loginUsername() => 'required', 'password' => 'required',
				]);
		} else {
			$this->validate($request, [
				$this->loginUsername() => 'required', 'password' => 'required',
				'g-recaptcha-response' => 'required|captcha',
				]);
		}
		
	}

// Finaliza Autenticação
	protected function handleUserWasAuthenticated(Request $request, $throttles)
	{
		if ($throttles) {
			$this->clearLoginAttempts($request);
		}
		if(session('errorlogin')){
			session()->forget('errorlogin');
		}
		if (method_exists($this, 'authenticated')) {
			return $this->authenticated($request, Auth::guard($this->getGuard())->user());
		}
		SessionController::seedSession();
		return redirect()->intended($this->redirectPath());
	}

// Validação de Cadastro
	protected function validator(array $data)
	{
		if(session('errorregister')){
			return Validator::make($data, [
				'name' => 'required|min:3|max:255',
				'email' => 'required|email|max:255|unique:users',
				'password' => 'required|min:8|confirmed',
				'usuCpf' => 'required|min:11|unique:users',
				'g-recaptcha-response' => 'required|captcha',
				]);
		} else {
			return Validator::make($data, [
				'name' => 'required|min:3|max:255',
				'email' => 'required|email|max:255|unique:users',
				'password' => 'required|min:6|confirmed',
				'usuCpf' => 'required|min:11|unique:users',
				]);
		}
	}


// Criação de Usuário
	protected function create(array $data)
	{
		if(session('errorregister')){
			session()->forget('errorregister');
		}
		return User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
			'usuCpf' => $data['usuCpf'],
			]);
	}


	// Função de Controller de Cadastro
	public function register(Request $request)
	{
		$validator = $this->validator($request->all());

		if ($validator->fails()) {
			session(['errorregister'=>'errorregister']);
			$this->throwValidationException(
				$request, $validator
				);
		}
		$user = $this->create($request->all());

		Mail::send('auth.emails.confirmacao', ['user' => $user], function ($message) use ($user) {
			$message->from('cadastro@eventosifmg.com', 'Eventos IFMG');
			$message->to($user->email, $user->name)->subject('Termine seu cadastro!');
		});

		$user->usu_staCod=1;
		$user->save();
		return redirect('/confirmacao')->with('email',$user->email);
	}


// Caso o email seja enviado
	public function emailEnviado()
	{
		return view('auth.emailenviado');
	}

// Retorna a view parar confirmar o cadastro
	public function confirmaCadastro($id,$email)
	{
		$user = User::where('id',$id)
		->where('email',$email)
		->first();
		if(!$user){
			return view('mensagem','Usuario Não Existe');
		} elseif($user->usu_staCod!=1){
			return view('mensagem','Usuario Já Cadastrado');
		} else {
			return view('user.meusdados',array('user'=>$user,'area_conhecimento'=>Area_Conhecimento::all(),'titulos'=>Titulo::all()));
		}
	}

// Confirmação Cadastro
	public function registrarDados(Request $request)
	{
		$user = User::where('email',$request->email)
		->first();
		$user->name=$request->nome;
		$user->usuRG=$request->rg;
		$user->usuMatricula=$request->matricula;
		$user->usuInstituicaoVinculo=$request->instvinc;
		$user->usuObsPne=$request->obsesp;
		$user->usuLattes=$request->lattes;
		$user->usuTel1=$request->telefone1;
		$user->usuTel2=$request->telefone2;
		$user->usuDataNascimento=$request->data;
		$user->usu_endCod=$this->criaEndereco($request);
		$user->usu_forCod=$this->criaFormacaoAcademica($request);
		$user->usu_UltimoLog=1;
		$user->usu_TipoPerfil=1;
		$user->usu_staCod=2;
		$user->Save();
		Auth::login($user);
		SessionController::seedSession();
		return redirect('');
	}

// Criação do Endereço ao Confirmar Cadastro
	public function criaEndereco(Request $request)
	{
		$endereco = new endereco();
		$endereco->endNumero=$request->numero; 
		$endereco->endBairro=$request->bairro; 
		$endereco->endCidade=$request->cidade; 
		$endereco->endEstado=$request->uf;    
		$endereco->endCEP=$request->cep; 
		$endereco->endPais=$request->pais; 
		$endereco->endComplemento=$request->complemento; 
		$endereco->endRua=$request->rua;  
		$endereco->Save();
		return $endereco->endCod;
	}

// Criação da Formação Acadêmica ao Confirmar Cadastro
	public function criaFormacaoAcademica(Request $request)
	{
		$acade= new formacaoacademica();
		$acade->for_titCod=$request->titulo; 
		$acade->for_areCod=$request->areaconhecimento; 
		$acade->forInstituicao=$request->instituicao; 
		$acade->forAno=$request->ano;  
		$acade->Save();
		return $acade->forCod; 
	}


// Retorna a view do Esqueci Meu Email
	public function getEsqueciEmail(){
		return view('auth.esqueciemail');
	}

// Controller do Esqueci Meu Email
	public function postEsqueciEmail(Request $request){
		$query=DB::table('users')
		->where('usuCPF',$request->cpf)
		->value('email');
		if($query){
			return view('auth.retornaemail',array('email'=>$query));
		} else {
			return redirect()->back()
			->withInput($request->only('cpf'))
			->withErrors(['cpf' => "CPF não cadastrado!"]);

		}
	}

}
