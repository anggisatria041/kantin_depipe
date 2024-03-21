<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data=User::all();

        return response()->json([
            'status'=>true,
            'message'=>'Data ditemukan',
            'data'=>$data,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(Request $request)
    {
        $user = User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->input('password')),
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'nik' => $request->nik,
            'logo' => $request->logo,
            'role' => $request->role
        ]);
        return response()->json([
            'status'=>true,
            'message'=>'Sukses Memasukkan Data',
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data=User::find($id);
        if($data){
            return response()->json([
                'status'=>true,
                'message'=>'Data ditemukan',
                'data'=>$data,
            ], 200);
         
        } else{
             
            return response()->json([
                'status'=>false,
                'message'=>'Data tidak ditemukan',
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = User::find($id);

        if(empty($data)){
            return response()->json([
                'status'=>false,
                'message'=>'Data gagal ditemukan'
            ],404);
        }
        
        $rules=[
            'nama'=>'required',
            'username'=>'required',
            'email'=>'required|email',
            'password'=>'required',
            'logo'=>'required',
            'alamat'=>'required',
            'no_hp'=>'required',
            'nik'=>'required'
        ];
        $validator=Validator::make($request->all(),$rules);

        if($validator->fails()){
            return response()->json([
                'status'=>false,
                'message'=>'Gagal melakukan update data',
                'data'=>$validator->errors()
            ]);
        }
        
        $data->nama = $request->nama;
        $data->username = $request->username;
        $data->email = $request->email;
        $data->password = Hash::make($request->input('password'));
        $data->logo = $request->logo;
        $data->alamat = $request->alamat;
        $data->no_hp = $request->no_hp;
        $data->nik = $request->nik;

        $post = $data->save();

        return response()->json([
            'status'=>true,
            'message'=>'Sukses Melakukan update Data',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = User::find($id);

        if(empty($data)){
            return response()->json([
                'status'=>false,
                'message'=>'Data gagal ditemukan'
            ],404);
        }

        $post = $data->delete();

        return response()->json([
            'status'=>true,
            'message'=>'Sukses Melakukan delete Data',
        ]);
    }
    public function login(Request $request)
    {
        try {
            $rules=[
                'username' => 'required',
                'password' => 'required'
            ];
            $validator=Validator::make($request->all(),$rules);

            if($validator->fails()){
                return response()->json([
                    'status'=>false,
                    'message'=>'Silahkan Lengkapi Data Anda',
                    'data'=>$validator->errors()
                ]);
            }

        $credentials= request(['username','password']);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                    'status'=>false,
                    'message'=>'Username atau Password anda Salah'
                ],404);
        }
        // cek username
            $user = User::where('username', $request->username)->first();
            // cek password
            if (!Hash::check($request->password, $user->password,[])) {
                return response([
                    'message' => 'Bad Credentials'
                ], 401);
            }
            
        
            $token = $user->createToken('authtoken')->plainTextToken;
            $response = [
                'data' => [
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'user'=>$user
                ]
            ];
            return response($response, 201);
        } catch (Exception $error) {
            return $this->errors([
                'message' => 'Something went wrong',
                'error' => $error
            ], 'Login Failed');
        }

    } 
    public function logout()
    {
        $user = User::find(Auth::user()->id);
        $user->tokens()->delete();

        // auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }
    public function auth()
    {
        return [
            'message' => 'Anda belum memiliki akses'
        ];
    }
}
