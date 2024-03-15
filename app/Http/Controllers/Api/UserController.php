<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
            'Data'=>$data,
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
    public function store(Request $request)
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

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
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
}
