<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Menu;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $id = Auth::user()->id;
        $data = Pesanan::whereJsonContains('pesanan', [['tenant_id' => $id]]);

        if ($request->has('status_pemesanan')) {
            $status = $request->input('status_pemesanan');
            if ($status != 'Semua') {
                $data->where('status_pemesanan', $status);
            }
        }

        // Filter berdasarkan jenis pemesanan
        if ($request->has('jenis_pemesanan')) {
            $jenis = $request->input('jenis_pemesanan');
            if ($jenis != 'Semua') {
                $data->where('jenis_pemesanan', $jenis);
            }
        }
        $data = $data->get();

        $formattedData = $data->map(function($item) {
            $pesanan = json_decode($item->pesanan);
            $formattedPesanan = [];
            foreach ($pesanan as $pesananItem) {
                $formattedPesanan[] = [
                    'menu_id' => $pesananItem->menu_id,
                    'tenant_id' => $pesananItem->tenant_id,
                    'qty' => $pesananItem->qty,
                    'harga' => $pesananItem->harga,
                    'total' => $pesananItem->total
                ];
            }

            return [
                'pesanan_id' => $item->pesanan_id,
                'order_id' => $item->order_id,
                'keterangan' => $item->keterangan,
                'pesanan' => $formattedPesanan,
                'jenis_pemesanan' => $item->jenis_pemesanan,
                'metode_pembayaran' => $item->metode_pembayaran,
                'status_pemesanan' => $item->status_pemesanan,
                'status_pembayaran' => $item->status_pembayaran,
                'no_meja' => $item->no_meja,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Data Berhasil Ditemukan',
            'data' => $formattedData,
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
            'pesanan'=>'required',
            'jenis_pemesanan'=>'required',
            'metode_pembayaran'=>'required',
            'status_pemesanan'=>'required',
            'status_pembayaran'=>'required',
        ];
        $validator=Validator::make($request->all(),$rules);

        if($validator->fails()){
            return response()->json([
                'status'=>false,
                'message'=>'Gagal Menambahkan Data',
                'data'=>$validator->errors()
            ], 500);
        }
        $pesanan = json_decode($request->pesanan, true); 
        $data = new Pesanan;
        foreach ($pesanan as $item) {
            $menu = Menu::find($item['menu_id']); 
            if ($menu) {
                $menu->stok -= $item['qty'];
                $menu->save(); 
            }
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
            'message'=>'Berhasil Menambahkan Data',
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $idInteger = intval($id);
        if($idInteger){
            $data = Pesanan::whereJsonContains('pesanan', [['tenant_id' => $idInteger]])->get();

            $formattedData = $data->map(function($item) {
                $pesanan = json_decode($item->pesanan);
                $formattedPesanan = [];
                foreach ($pesanan as $pesananItem) {
                    $formattedPesanan[] = [
                        'menu_id' => $pesananItem->menu_id,
                        'tenant_id' => $pesananItem->tenant_id,
                        'qty' => $pesananItem->qty,
                        'harga' => $pesananItem->harga,
                        'total' => $pesananItem->total
                    ];
                }

                return [
                    'pesanan_id' => $item->pesanan_id,
                    'order_id' => $item->order_id,
                    'keterangan' => $item->keterangan,
                    'pesanan' => $formattedPesanan,
                    'jenis_pemesanan' => $item->jenis_pemesanan,
                    'metode_pembayaran' => $item->metode_pembayaran,
                    'status_pemesanan' => $item->status_pemesanan,
                    'status_pembayaran' => $item->status_pembayaran,
                    'no_meja' => $item->no_meja,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at
                ];
            });

            return response()->json([
                'status' => true,
                'message' => 'Data Berhasil Ditemukan',
                'data' => $formattedData,
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
