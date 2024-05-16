<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventori;
use App\Models\Stok_barang;
use Illuminate\Support\Facades\Validator;

class InventoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barang=Stok_barang::all();
        return view("page.inventori",compact('barang'));
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
            'stok_barang_id' => 'required',
            'tanggal_pembelian' => 'required',
            'jumlah_pembelian' => 'required'
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
        $barang = Stok_barang::findOrFail($id);

        $data = Inventori::create([
            'stok_barang_id' => $request->stok_barang_id,
            'tanggal_pembelian' => $request->tanggal_pembelian,
            'jumlah_pembelian' => $request->jumlah_pembelian,
            'total_bayar' => ($request->jumlah_pembelian * $barang->harga_beli)
        ]);
        $barang = Stok_barang::find($request->stok_barang_id);
        $barang->stok += $request->jumlah_pembelian; 
        $barang->save();

        if ($data) {
            return response()->json([
                'status' => true,
                'message' => 'Sukses Memasukkan Data',
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
        $data = Inventori::findOrFail($id);
        return response()->json(['data' => $data], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->inventori_id;
        $data = Inventori::find($id);

        $rules = [
            'stok_barang_id' => 'required',
            'tanggal_pembelian' => 'required',
            'jumlah_pembelian' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Semua Data Harus Terisi',
                'data' => $validator->errors()
            ]);
        }
        $perbedaan = $request->jumlah_pembelian - $data->jumlah_pembelian;
        $barang = Stok_barang::find($request->stok_barang_id);
        $barang->stok += $perbedaan; 
        $barang->save();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data Inventori tidak ditemukan',
            ]);
        }

        $id=$request->stok_barang_id;
        $barang = Stok_barang::findOrFail($id);

        $data->update([
            'stok_barang_id' => $request->stok_barang_id,
            'tanggal_pembelian' => $request->tanggal_pembelian,
            'jumlah_pembelian' => $request->jumlah_pembelian,
            'total_bayar' => ($request->jumlah_pembelian * $barang->harga_beli)

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
        $data = Inventori::find($id);

        if (empty($data)) {
            return response()->json([
                'status' => false,
                'message' => 'Data gagal ditemukan'
            ], 404);
        }

        $data->delete();

        return response()->json([
            'status' => true,
            'message' => 'Sukses Melakukan delete Data',
        ]);
    }
    public function data_list()
    {
        $dt = Inventori::leftJoin('stok_barang as sb', 'sb.stok_barang_id', '=', 'inventori.stok_barang_id')
        ->select('inventori.*', 'sb.nama')
        ->orderBy('inventori.inventori_id', 'desc')
        ->get();
        $data = array();
        $start = 0;
        foreach ($dt as $key => $value) {
            $td = array();
            $td['no'] = ++$start;
            $td['inventori_id'] = $value->inventori_id ?? '-';
            $td['stok_barang_id'] = $value->stok_barang_id ?? '-';
            $td['nama'] = $value->nama ?? '-';
            $td['tanggal_pembelian'] = $value->tanggal_pembelian ?? '-';
            $td['jumlah_pembelian'] = $value->jumlah_pembelian ?? '-';
            $td['total_bayar'] = isset($value->total_bayar) ? 'Rp ' . number_format($value->total_bayar, 0, ',', '.') : '-';
            $td['actions'] ='<a href="javascript:void(0)" onclick="edit(\''.$value->inventori_id.'\')" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit">
                                <i class="la la-edit"></i>
                            </a>
                            <a href="javascript:void(0)" onclick="hapus(\''.$value->inventori_id.'\')" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">
                                <i class="la la-trash-o"></i>
                            </a>';
            $data[] = $td;
        }
        return response()->json(['data' => $data]);
    }
}
