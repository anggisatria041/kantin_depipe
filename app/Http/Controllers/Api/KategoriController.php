<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Post(
 *     path="/api/kategori",
 *     summary="Tambah data kategori",
 *     description="Melakukan Tambah Data Kategori",
 *     tags={"Kategori"},
 *     @OA\Parameter(
 *         name="nama_kategori",
 *         in="query",
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Kategori Berhasil Ditambah",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Kategori Berhasil Ditambah"
 *             ),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 example={}
 *             )
 *         )
 *     )
 * )
 * @OA\Get(
 *      path="/api/kategori",
 *      tags={"Kategori"},
 *      operationId="kategori",
 *      summary="Kategori",
 *      description="Mengambil Data Kategori ",
 *      @OA\Response(
 *           response="200",
 *           description="Ok",
 *           @OA\JsonContent(
 *               example={
 *                   "success": true,
 *                   "message": "Berhasil mengambil Kategori ",
 *                   "data": {
 *                       {
 *                       "kategori_id": "111",
 *                       "nama_kategori": "Makanan"
 *                       }
 *                   }
 *               }
 *           )
 *      )
 * )
 * @OA\Get(
 *      path="/api/kategori/{id}",
 *      tags={"Kategori"},
 *      operationId="getKategoriById",
 *      summary="Kategori By Id",
 *      description="Mengambil Data Kategori berdasarkan kategori_id",
 *      @OA\Parameter(
 *          name="id",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="string"
 *          ),
 *          description="ID dari kategori yang ingin diambil"
 *      ),
 *      @OA\Response(
 *           response="200",
 *           description="Ok",
 *           @OA\JsonContent(
 *               example={
 *                   "success": true,
 *                   "message": "Data Berhasil Ditemukan",
 *                   "data": {
 *                       "kategori_id": "111",
 *                       "nama_kategori": "Makanan"
 *                   }
 *               }
 *           )
 *      )
 * )
 * @OA\Put(
 *      path="/api/kategori/{id}",
 *      tags={"Kategori"},
 *      operationId="updateKategoriById",
 *      summary="Update Kategori By Id",
 *      description="Memperbarui Data Kategori berdasarkan kategori_id",
 *      @OA\Parameter(
 *          name="id",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="string"
 *          ),
 *          description="ID dari kategori yang ingin diperbarui"
 *      ),
 *      @OA\Parameter(
 *          name="nama_kategori",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="string"
 *          ),
 *          description="Nama kategori yang ingin diperbarui"
 *      ),
 *      @OA\Response(
 *           response="200",
 *           description="Kategori Berhasil Diperbarui",
 *           @OA\JsonContent(
 *               example={
 *                   "success": true,
 *                   "message": "Kategori Berhasil Diperbarui",
 *                   "data": {
 *                       "kategori_id": "111",
 *                       "nama_kategori": "Minuman"
 *                   }
 *               }
 *           )
 *      )
 * )
 * @OA\Delete(
 *      path="/api/kategori/{id}",
 *      tags={"Kategori"},
 *      operationId="deleteKategoriById",
 *      summary="Delete Kategori By Id",
 *      description="Menghapus Data Kategori berdasarkan kategori_id",
 *      @OA\Parameter(
 *          name="id",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="string"
 *          ),
 *          description="ID dari kategori yang ingin dihapus"
 *      ),
 *      @OA\Response(
 *           response="200",
 *           description="Kategori Berhasil Dihapus",
 *           @OA\JsonContent(
 *               example={
 *                   "success": true,
 *                   "message": "Kategori Berhasil Dihapus"
 *               }
 *           )
 *      ),
 *      @OA\Response(
 *           response="404",
 *           description="Not Found",
 *           @OA\JsonContent(
 *               example={
 *                   "success": false,
 *                   "message": "Kategori tidak ditemukan"
 *               }
 *           )
 *      )
 * )
 */


class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data=Kategori::all();

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
        $data = new Kategori;
        
        $rules=[
            'nama_kategori'=>'required'
        ];
        $validator=Validator::make($request->all(),$rules);

        if($validator->fails()){
            return response()->json([
                'status'=>false,
                'message'=>'Gagal Menambahkan Data',
                'data'=>$validator->errors()
            ],500);
        }
        $data->nama_kategori = $request->nama_kategori;

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
        $data=Kategori::find($id);

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
    public function update(Request $request, string $id)
    {
        $data = Kategori::find($id);

        if(empty($data)){
            return response()->json([
                'status'=>false,
                'message'=>'Data Gagal Ditemukan'
            ],404);
        }
        
        $rules=[
            'nama_kategori'=>'required'
        ];
        $validator=Validator::make($request->all(),$rules);

        if($validator->fails()){
            return response()->json([
                'status'=>false,
                'message'=>'Gagal Melakukan Update Data',
                'data'=>$validator->errors()
            ],400);
        }
        
        $data->nama_kategori = $request->nama_kategori;

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
        $data = Kategori::find($id);

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
