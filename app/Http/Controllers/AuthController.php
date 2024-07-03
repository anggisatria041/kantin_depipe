<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function postlogin(Request $request)
    {
        try {
            $rules = [
                'email' => 'required|email',
                'password' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect('/portal')->withErrors($validator)->withInput();
            }

            $credentials = $request->only('email', 'password');
            if (!Auth::attempt($credentials)) {
                return redirect('/portal')->with('error', 'Email atau Password Anda Salah');
            }

            // cek email
            $user = Auth::user();
            // cek password
            if (!Hash::check($request->password, $user->password)) {
                return redirect('/portal')->with('error', 'Bad Credential');
            }

            $token = $user->createToken('authtoken')->plainTextToken;

            if ($user->role == 'admin') {
                return redirect('/dashboard');
            } elseif ($user->role == 'kasir') {
                return redirect()->route('penjualan.index');
            } else {
                return redirect('/portal')->with('error', 'Tidak memiliki akses admin!');
            }
        } catch (Exception $error) {
            return redirect('/portal')->with('error', 'Login Failed!');
        }
    }

    public function logout()
    {
        Auth::guard('web')->logout(); 
        return redirect('/portal');
    }
    public function login()
    {
        return view('page.login');
    }
    public function lawang()
    {
        return view('page.login');
    }
}
