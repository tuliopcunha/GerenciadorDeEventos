<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SessionController;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Hash;
use Auth;
use DB;


class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      $this->middleware('guest');
    }

    protected function getEmailSubject()
    {
      return property_exists($this, 'subject') ? $this->subject : 'Link para redefinição de senha:';
    }

    public function reset(Request $request)
    {
      $this->validate(
        $request,
        $this->getResetValidationRules(),
        $this->getResetValidationMessages(),
        $this->getResetValidationCustomAttributes()
        );
      $user = DB::table('users')->where('email', '=', $request->input('email'))->get();
      $user=$user[0];
      if($user->usu_staCod==1){
            return redirect()->back()
          ->withInput($request->only('email'))
          ->withErrors(['email' => 'Usuário não confirmado']);
    }
      if(isset($user->passwordOld)){
        if (Hash::check($request->password, $user->passwordOld)){
          return redirect()->back()
          ->withInput($request->only('email'))
          ->withErrors(['password' => 'Senha já definida anteriormente']);
        } else {
          if(isset($user->passwordOld2)){
            if (Hash::check($request->password, $user->passwordOld2)){
              return redirect()->back()
              ->withInput($request->only('email'))
              ->withErrors(['password' => 'Senha já definida anteriormente']);
            } else {
              return $this->alteraUsuarioPassword($user,$request);
            }
          } else {
            return $this->alteraUsuarioPassword($user,$request);
          }
        }
      } else {
        return $this->alteraUsuarioPassword($user,$request);
      }
    }

    protected function getResetSuccessResponse($response)
    {
      SessionController::seedSession();
      return redirect($this->redirectPath())->with('status', trans($response));
    } 

    protected function alteraUsuarioPassword($user,Request $request){
      $user->passwordOld2=$user->passwordOld;
      $user->passwordOld=$user->password;
      $credentials = $request->only(
        'email', 'password', 'password_confirmation', 'token'
        );

      $broker = $this->getBroker();
      
      $response = Password::broker($broker)->reset($credentials, function ($user, $password) {
        $this->resetPassword($user, $password);
      });

      switch ($response) {
        case Password::PASSWORD_RESET:
        return $this->getResetSuccessResponse($response);

        default:
        return $this->getResetFailureResponse($request, $response);
      }

    }

  }