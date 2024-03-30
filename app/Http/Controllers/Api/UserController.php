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
            'message'=>'Data Berhasil Ditemukan',
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
        $data = new User;
        
        $rules=[
            'nama'=>'required',
            'username'=>'required',
            'email'=>'required|email',
            'password'=>'required',
            'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'alamat'=>'required',
            'no_hp'=>'required',
            'nik'=>'required'
        ];
        $validator=Validator::make($request->all(),$rules);

        if($validator->fails()){
            return response()->json([
                'status'=>false,
                'message'=>'Gagal Menambahkan Data',
                'data'=>$validator->errors()
            ], 500);
        }
        if ($request->hasFile('logo')) {
            $gambarPath = $request->file('logo')->store('', 'public'); 
            $logo = $gambarPath;
        } else {
            $logo = null;
        }
        $data->nama = $request->nama;
        $data->username = $request->username;
        $data->email = $request->email;
        $data->password = Hash::make($request->input('password'));
        $data->logo = $logo;
        $data->alamat = $request->alamat;
        $data->no_hp = $request->no_hp;
        $data->nik = $request->nik;
        $data->role = 'tenant';

        $post = $data->save();

        return response()->json([
            'status'=>true,
            'message'=>'Berhasil Menambahkan Data',
            'data'=>$data,
        ], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $data=Auth::user();
        if($data){
            return response()->json([
                'status'=>true,
                'message'=>'Data Berhasil Ditemukan',
                'data'=>$data,
            ], 200);
         
        } else{
            return response()->json([
                'status'=>false,
                'message'=>'Data Gagal Ditemukan',
            ], 404);
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
                'message'=>'Data Gagal Ditemukan'
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
                'message'=>'Gagal Melakukan Update Data',
                'data'=>$validator->errors()
            ], 500);
        }
        if ($request->hasFile('logo')) {
            $gambarPath = $request->file('logo')->store('', 'public'); 
            $logo = $gambarPath;
            $data->update([
                'logo' => $logo
            ]);
        }
        $data->nama = $request->nama;
        $data->username = $request->username;
        $data->email = $request->email;
        $data->password = Hash::make($request->input('password'));
        $data->alamat = $request->alamat;
        $data->no_hp = $request->no_hp;
        $data->nik = $request->nik;

        $post = $data->save();

        return response()->json([
            'status'=>true,
            'message'=>'Berhasil Melakukan Update Data',
        ], 200);
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
                'message'=>'Data Gagal Ditemukan'
            ],404);
        }

        $post = $data->delete();

        return response()->json([
            'status'=>true,
            'message'=>'Berhasil Melakukan Delete Data',
        ], 200);
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
                ], 500);
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
                'status' => true,
                'message' => 'Berhasil Login',
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

        return response([
            'status'=>true,
            'message' => 'Anda Berhasil Logout'
        ], 200);
    }
    public function auth()
    {
        return response([
            'status'=>false,
            'message' => 'Anda belum memiliki akses'
        ], 401);
    }
}
