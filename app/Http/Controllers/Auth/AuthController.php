<?php


namespace App\Http\Controllers\Auth;


use App\Helper\CustomController;
use Illuminate\Support\Facades\Auth;

class AuthController extends CustomController
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest')->except('logout');
    }

    public function login()
    {
        $credentials = [
            'username' => $this->postField('username'),
            'password' => $this->postField('password')
        ];
        if ($this->isAuth($credentials)) {
            return redirect('/dashboard');
        }
        return redirect()->back()->withInput()->with('failed', 'Periksa Kembali Username dan Password Anda');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
