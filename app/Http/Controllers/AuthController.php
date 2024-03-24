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
            $rules=[
                'email' => 'required|email',
                'password' => 'required'
            ];
            $validator=Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                $errors = $validator->errors();

                if ($errors->has('email')) {
                    return redirect('/portal')->with('error', 'Email harus diisi');
                }

                if ($errors->has('password')) {
                    return redirect('/portal')->with('error', 'Password harus diisi');
                }
            }

        $credentials= request(['email','password']);
        if (!Auth::attempt($credentials)) {
            return redirect('/portal')->with('error','Email atau Password Anda Salah');
        }
            // cek email
            $user = User::where('email', $request->email)->first();
            // cek password
            if (!Hash::check($request->password, $user->password,[])) {
               return redirect('/portal')->with('error','Bad Credential');
            }
            
            $token = $user->createToken('authtoken')->plainTextToken;
            return redirect('/dashboard');
        } catch (Exception $error) {
            return redirect('/portal')->with('error', 'Loggin Failed!');
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
