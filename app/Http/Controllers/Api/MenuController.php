<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data=Menu::all();

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
        $data = new Menu;
        
        $rules=[
            'nama'=>'required',
            'stok'=>'required',
            'kategori'=>'required',
            'harga'=>'required',
            'deskripsi'=>'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ];
        $validator=Validator::make($request->all(),$rules);

        if($validator->fails()){
            return response()->json([
                'status'=>false,
                'message'=>'Gagal Menambahkan Data',
                'data'=>$validator->errors()
            ]);
        }
        $gambarPath = $request->file('gambar')->store('', 'public');

        $data->tenant_id = Auth::user()->id;
        $data->nama = $request->nama;
        $data->stok = $request->stok;
        $data->kategori = $request->kategori;
        $data->gambar = $gambarPath;
        $data->harga = $request->harga;
        $data->deskripsi = $request->deskripsi;

        $post = $data->save();

        return response()->json([
            'status'=>true,
            'message'=>'Berhasil Menambahkan Data',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data=Menu::find($id);
        if($data){

            return response()->json([
                'status'=>true,
                'message'=>'Data Berhasil Ditemukan',
                'Data'=>$data,
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
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = Menu::find($id);

        if(empty($data)){
            return response()->json([
                'status'=>false,
                'message'=>'Data Gagal Ditemukan'
            ],404);
        }
        
        $rules=[
            'nama'=>'required',
            'stok'=>'required',
            'deskripsi'=>'required',
            'harga'=>'required'
        ];
        $validator=Validator::make($request->all(),$rules);

        if($validator->fails()){
            return response()->json([
                'status'=>false,
                'message'=>'Gagal Melakukan Update Data',
                'data'=>$validator->errors()
            ]);
        }
        $gambarPath = $request->file('gambar')->store('', 'public');
        
        $data->nama = $request->nama;
        $data->stok = $request->stok;
        $data->kategori = $request->kategori;
        $data->gambar = isset($gambarPath)?$gambarPath:$request->gambar;
        $data->harga = $request->harga;
        $data->deskripsi = $request->deskripsi;

        $post = $data->save();

        return response()->json([
            'status'=>true,
            'message'=>'Berhasil Melakukan Update Data',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Menu::find($id);

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
