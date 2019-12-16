<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    protected $user;

    protected $auth;

    public function __construct(Guard $auth, User $user) {
        $this->user = $user;
        $this->auth = $auth;

        $this->middleware('guest', ['except' => ['getLogout']]);
    }

    public function getRegister() {
        return view('auth.register');
    }

    public function postRegister(RegisterRequest $request) {
        $this->user->name = $request->name;
        $this->user->email = $request->email;
        $this->user->password = bcrypt($request->password);
        $this->user->save();
        $this->auth->login($this->user);

        return redirect('/dashboard');
    }

    public function getLogin() {
        return view('auth.login');
    }

    public function postLogin(LoginRequest $request) {
        if ($this->auth->attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1], $request->remember)) {
            return redirect()->intended('/dashboard');
        }

        return redirect('/auth/login')->withErrors([
            'email' => 'The credentials you entered did not match our records. Try again?',
        ]);
    }

    public function getLogout() {
        $this->auth->logout();
        return redirect('/');
    }
}
