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
            'order_id'=>'required',
            'keterangan'=>'required',
            'pesanan'=>'required',
            'jenis_pemesanan'=>'required',
            'metode_pembayaran'=>'required',
            'status_pemesanan'=>'required',
            'status_pembayaran'=>'required',
            'no_meja'=>'required',
        ];
        $validator=Validator::make($request->all(),$rules);

        if($validator->fails()){
            return response()->json([
                'status'=>false,
                'message'=>'Gagal Menambahkan Data',
                'data'=>$validator->errors()
            ], 500);
        }
        dd($request->pesanan);
        $data->order_id = $request->order_id;
        $data->keterangan = $request->keterangan;
        $data->pesanan = $request->pesanan;
        $data->jenis_pemesanan = $request->jenis_pemesanan;
        $data->metode_pembayaran = $request->metode_pembayaran;
        $data->status_pemesanan = $request->status_pemesanan;
        $data->status_pembayaran = $request->status_pembayaran;
        $data->no_meja = $request->no_meja;

        $post = $data->save();

        return response()->json([
            'status'=>true,
            'message'=>'Berhasil Menambahkan Data',
        ],200);
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
        $data = Pesanan::find($id);

        if(empty($data)){
            return response()->json([
                'status'=>false,
                'message'=>'Data Gagal Ditemukan'
            ],404);
        }
        
        $rules=[
            'order_id'=>'required',
            'keterangan'=>'required',
            'pesanan'=>'required',
            'jenis_pemesanan'=>'required',
            'metode_pembayaran'=>'required',
            'status_pemesanan'=>'required',
            'status_pembayaran'=>'required',
            'no_meja'=>'required',
        ];
        $validator=Validator::make($request->all(),$rules);

        if($validator->fails()){
            return response()->json([
                'status'=>false,
                'message'=>'Gagal Melakukan Update Data',
                'data'=>$validator->errors()
            ],500);
        }
        
        $data->order_id = $request->order_id;
        $data->keterangan = $request->keterangan;
        $data->pesanan = $request->pesanan;
        $data->jenis_pemesanan = $request->jenis_pemesanan;
        $data->metode_pembayaran = $request->metode_pembayaran;
        $data->status_pemesanan = $request->status_pemesanan;
        $data->status_pembayaran = $request->status_pembayaran;
        $data->no_meja = $request->no_meja;

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
        ], 200);
    }
}
