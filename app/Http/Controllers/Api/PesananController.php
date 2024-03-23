<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Validator;


class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $data=Pesanan::all();

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
        $data = new Pesanan;
        
        $rules=[
            'menu_id'=>'required',
            'jumlah'=>'required',
            'total'=>'required',
            'no_meja'=>'required',
            'status'=>'required',

        ];
        $validator=Validator::make($request->all(),$rules);

        if($validator->fails()){
            return response()->json([
                'status'=>false,
                'message'=>'Gagal Menambahkan Data',
                'data'=>$validator->errors()
            ]);
        }
        $data->menu_id = $request->menu_id;
        $data->jumlah = $request->jumlah;
        $data->total = $request->total;
        $data->no_meja = $request->no_meja;
        $data->status = $request->status;

        $post = $data->save();

        return response()->json([
            'status'=>true,
            'message'=>'Berhasil Menambahkan Data',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data=Pesanan::find($id);
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
        $data = Pesanan::find($id);

        if(empty($data)){
            return response()->json([
                'status'=>false,
                'message'=>'Data Gagal Ditemukan'
            ],404);
        }
        
       $rules=[
            'menu_id'=>'required',
            'jumlah'=>'required',
            'total'=>'required',
            'no_meja'=>'required',
            'status'=>'required',

        ];
        $validator=Validator::make($request->all(),$rules);

        if($validator->fails()){
            return response()->json([
                'status'=>false,
                'message'=>'Gagal Melakukan Update Data',
                'data'=>$validator->errors()
            ]);
        }
        
        $data->menu_id = $request->menu_id;
        $data->jumlah = $request->jumlah;
        $data->total = $request->total;
        $data->no_meja = $request->no_meja;
        $data->status = $request->status;

        $post = $data->save();

        return response()->json([
            'status'=>true,
            'message'=>'Berhasil Melakukan Update Data',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Pesanan::find($id);

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
        ]);
    }
}
