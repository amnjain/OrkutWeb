<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class AuthController extends Controller
{
    public function getSignup()
    {
    	return view('auth.signup');
    }

    public function postSignup(Request $request){
    	$this->validate($request, [
    			'email' => 'required|unique:users|email|max:255',
    			'username' => 'required|unique:users|alpha_dash|max:20',
    			'password' => 'required|min:6',
    	]);

    	$user = User::create([
    		'email' => $request->input('email'),
    		'username' => $request->input('username'),
    		'password' => bcrypt($request->input('password')),
    	]);

      auth()->login($user);

    	return redirect()->route('home')->with('info','Cheeers!! Your account is created!');
    }

    public function getSignin()
    {
    	return view('auth.signin');
    }

    public function postSignin(Request $request)
    {
    	$this->validate($request, [
    			'email' => 'required',
    			'password' => 'required',
    	]);

    	if(!Auth::attempt($request->only(['email', 'password']), $request->has('remember'))){
    		return redirect()->back()->with('info', 'Could not find this account! ');

    	}

    	return redirect()->route('home')->with('info', 'You are signed in');
    }

    public function getSignout(){
    	Auth::logout();

    	return redirect()->route('home')->with('info', 'You are logged out');
    }

}
