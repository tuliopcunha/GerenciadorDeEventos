<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		SessionController::seedSession();
		return view('home');
	}

	public function retornaSobre(){
		return view('sobre');
	}
	
}
