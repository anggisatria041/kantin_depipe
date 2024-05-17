<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Stok_barang;
use App\Models\Karyawan;
use App\Models\Piutang;
use App\Models\Saldo;


use Illuminate\Support\Facades\Validator;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $karyawan=Karyawan::all();

        $no = Penjualan::select('no_transaksi')
        ->orderBy('penjualan_id', 'desc')
        ->limit(1)
        ->first();
        $month                 = date('m');
        $tahun                 = date('Y');

        if (isset($no->no_transaksi)) {
            $order= $no->no_transaksi;
            $pecah = explode("/",  $order);
            $seq = $pecah[0];
            $no_order = $seq + 1;
        } else {
            $no_order = 1;
        }
        $no_transaksi = sprintf("%04s", $no_order) . '/KSR/' . $tahun; 
        return view("page.penjualan",compact('no_transaksi','karyawan'));
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
        $rules = [
            'stok_barang_id' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memasukkan data',
                'data' => $validator->errors()
            ]);
        }
        $id=$request->stok_barang_id;
        $data = Stok_barang::find($id);

        $barang = Stok_barang::find($id);
        $barang->stok -= $request->jumlah; 
        $barang->save();

        if ($data->stok < $request->jumlah) {
            return response()->json([
                'status' => false,
                'message' => 'Stok tidak mencukupi'
            ]);
        }

        $data = Penjualan::create([
            'stok_barang_id' => $id
        ]);
        $total_bayar = Penjualan::where('status', 1)->sum('total_bayar');
        if ($data) {
            return response()->json([
                'status' => true,
                'message' => 'Sukses Memasukkan Data',
                'bayar'=> $total_bayar
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan data',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request)
    {
        $data = Penjualan::where('status',1);

        $karyawan=$request->karyawan_id;
        $pelanggan=$request->pelanggan;
        
        if($pelanggan == 'hutang'){
            if($karyawan){
                $piutang = Piutang::where('karyawan_id', $karyawan)->first();
                $total_bayar = Penjualan::where('status', 1)->sum('total_bayar');
                if($piutang){
                    $piutang->piutang += $total_bayar; 
                    $piutang->save();
                }else{
                    $piutang = Piutang::create([
                        'karyawan_id' => $karyawan,
                        'piutang' => $total_bayar
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Anda belum memilih karyawan',
                ]);
            }
            
        } else if($pelanggan == 'anggota koperasi'){

            if($karyawan){
                $saldo = Saldo::where('karyawan_id', $karyawan)->first();
                $total_bayar = Penjualan::where('status', 1)->sum('total_bayar');
                $hasil=$total_bayar - ($saldo->saldo);

                if($saldo->saldo >= $total_bayar){
                    $saldo->saldo -= $total_bayar; 
                    $saldo->save();
                } else{
                    $bayar=$request->bayar;
                    $saldo->saldo = 0; 
                    $saldo->save();
                    
                    if($bayar < $hasil){
                        $hutang = $hasil - $bayar;
                        $piutang = Piutang::where('karyawan_id', $karyawan)->first();
                        if($piutang){
                            $piutang->piutang += $hutang; 
                            $piutang->save();
                        }else{
                            $piutang = Piutang::create([
                                'karyawan_id' => $karyawan,
                                'piutang' => $hutang
                            ]);
                        }
                    }
                }
            }else {
                return response()->json([
                    'status' => false,
                    'message' => 'Anda belum memilih karyawan',
                ]);
            }
            

        }

        $data->update([
            'no_transaksi' => $request->no_transaksi,
            'tanggal' => $request->tanggal,
            'pelanggan' => $request->pelanggan,
            'status' => 2
        ]);

        if ($data) {
            return response()->json([
                'status' => true,
                'message' => 'Sukses Mengubah Data',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Gagal Mengubah data',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Penjualan::find($id);

        if (empty($data)) {
            return response()->json([
                'status' => false,
                'message' => 'Data gagal ditemukan'
            ], 404);
        }
        $perbedaan = $data->jumlah;
        $barang = Stok_barang::find($data->stok_barang_id);
        $barang->stok += $perbedaan; 
        $barang->save();

        $data->status = 2;
        $updated = $data->save();

        return response()->json([
            'status' => true,
            'message' => 'Sukses Melakukan delete Data',
        ]);
    }
    public function data_list(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return response()->json(['data' => []]);
        }

        $dt = Stok_barang::whereIn("stok_barang_id", $ids)->get();

        $data = array();
        $total_bayar = 0;
        $start = 0;
        foreach ($dt as $key => $value) {
            $td = array();
            $td['no'] = ++$start;
            $td['stok_barang_id'] = $value->stok_barang_id ?? '-';
            $td['nama'] = $value->nama ?? '-';
            $td['harga_jual'] = $value->harga_jual ?? '-';
            $td['jumlah'] = 1;
            $td['total_bayar'] = $value->harga_jual;
            $total_bayar += $value->harga_jual;
            $data[] = $td;
        }
        return response()->json(['data' => $data, 'total_bayar' => $total_bayar]);
    }
    public function getBarcode(Request $request)
    {
        $text = $request->searchtext;
        $barang = Stok_barang::select('stok_barang_id', 'barcode','nama')
            ->where(function ($query) use ($text) {
                $query->where('stok_barang_id', 'like', '%' . strtolower($text) . '%')
                    ->orWhere('barcode', 'like', '%' . strtolower($text) . '%')
                    ->orWhere('nama', 'like', '%' . strtolower($text) . '%');
        })->get();

        $output = [];
        $output['total_data'] = count($barang);
        
        foreach ($barang as $list) {
            $row['stok_barang_id'] = $list->stok_barang_id;
            $row['barcode'] = $list->barcode;
            $row['nama'] = $list->nama;
            $output['items'][] = $row;
        }

        return response()->json($output);
    }
    public function getSaldo(Request $request)
    {
        $karyawan_id = $request->karyawan_id;

        if ($karyawan_id) {
            $dt = Saldo::where('karyawan_id', $karyawan_id)->first();

            if ($dt) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'saldo' => $dt->saldo
                    ]
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'data' => [
                'saldo' => 0
            ]
        ]);
    }
}
