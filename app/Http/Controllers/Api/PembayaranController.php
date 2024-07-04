<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data=Pembayaran::all();

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
    public function store(Request $request)
    {
        $data = new Pembayaran;
        
        $rules=[
            'jenis_pembayaran'=>'required',
            'no_rek'=>'required'
        ];
        $validator=Validator::make($request->all(),$rules);

        if($validator->fails()){
            return response()->json([
                'status'=>false,
                'message'=>'Gagal Menambahkan Data',
                'data'=>$validator->errors()
            ],500);
        }
        if ($request->hasFile('foto')) {
            $gambarPath = $request->file('foto')->store('', 'public'); 
            $foto = $gambarPath;
        } else {
            $foto = null;
        }
        $data->tenant_id = Auth::user()->id;
        // $data->tenant_id = $request->tenant_id;
        $data->jenis_pembayaran = $request->jenis_pembayaran;
        $data->no_rek = $request->no_rek;
        $data->foto = $foto;

        $post = $data->save();

        return response()->json([
            'status'=>true,
            'message'=>'Berhasil Menambahkan Data',
            'data'=>$data,
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data=Pembayaran::find($id);

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
            ],404);
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
    public function update(Request $request,$id)
    {
        $data = Pembayaran::find($id);

        if(empty($data)){
            return response()->json([
                'status'=>false,
                'message'=>'Data Gagal Ditemukan'
            ],404);
        }
        
        $rules=[
            'jenis_pembayaran'=>'required',
            'no_rek'=>'required'
        ];
        $validator=Validator::make($request->all(),$rules);

        if($validator->fails()){
            return response()->json([
                'status'=>false,
                'message'=>'Gagal Melakukan Update Data',
                'data'=>$validator->errors()
            ],400);
        }
        
        $data->tenant_id = Auth::user()->id;
        // $data->tenant_id = $request->tenant_id;
        $data->jenis_pembayaran = $request->jenis_pembayaran;
        $data->no_rek = $request->no_rek;

        if ($request->hasFile('foto')) {
            $gambarPath = $request->file('foto')->store('', 'public'); 
            $foto = $gambarPath;
            $data->foto = $foto;
        }
        $post = $data->save();

        

        return response()->json([
            'status'=>true,
            'message'=>'Berhasil Melakukan Update Data',
            'data'=>$data,
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Pembayaran::find($id);

        if(empty($data)){
            return response()->json([
                'status'=>false,
                'message'=>'Data Gagal Ditemukan'
            ],404);
        }

        $post = $data->delete();

        return response()->json([
            'status'=>true,
            'message'=>'Sukses Melakukan Delete Data',
        ],200);
    }
}
