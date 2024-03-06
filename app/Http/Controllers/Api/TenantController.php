<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data=Tenant::all();

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
        $data = new Tenant;
        
        $rules=[
            'nama'=>'required',
            'email'=>'required|email',
            'password'=>'required',
            'logo'=>'required',
            'alamat'=>'required',
            'no_hp'=>'required',
            'ktp'=>'required'
        ];
        $validator=Validator::make($request->all(),$rules);

        if($validator->fails()){
            return response()->json([
                'status'=>false,
                'message'=>'Gagal memasukkan data',
                'data'=>$validator->errors()
            ]);
        }
        $data->menu_id = $request->menu_id;
        $data->nama = $request->nama;
        $data->email = $request->email;
        $data->password = Hash::make($request->input('password'));
        $data->logo = $request->logo;
        $data->alamat = $request->alamat;
        $data->no_hp = $request->no_hp;
        $data->ktp = $request->ktp;
        $data->role = 'tenant';

        $post = $data->save();

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
        $data=Tenant::find($id);
        if($data){

            return response()->json([
                'status'=>true,
                'message'=>'Data ditemukan',
                'Data'=>$data,
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
    public function update(Request $request, $id)
    {
        $data = Tenant::find($id);

        if(empty($data)){
            return response()->json([
                'status'=>false,
                'message'=>'Data gagal ditemukan'
            ],404);
        }
        
        $rules=[
            'nama'=>'required',
            'email'=>'required|email',
            'password'=>'required',
            'logo'=>'required',
            'alamat'=>'required',
            'no_hp'=>'required',
            'ktp'=>'required'
        ];
        $validator=Validator::make($request->all(),$rules);

        if($validator->fails()){
            return response()->json([
                'status'=>false,
                'message'=>'Gagal melakukan update data',
                'data'=>$validator->errors()
            ]);
        }
        
        $data->menu_id = $request->menu_id;
        $data->nama = $request->nama;
        $data->email = $request->email;
        $data->password = Hash::make($request->input('password'));
        $data->logo = $request->logo;
        $data->alamat = $request->alamat;
        $data->no_hp = $request->no_hp;
        $data->ktp = $request->ktp;

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
        $data = Tenant::find($id);

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
