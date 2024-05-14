<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Stok_barang;
use Illuminate\Support\Facades\Validator;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $total_bayar = Penjualan::where('status', 1)->sum('total_bayar');
        return view("page.penjualan",compact('total_bayar'));
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
            'jumlah' => 'required',
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

         $data = Penjualan::create([
            'stok_barang_id' => $id,
            'jumlah' => $request->jumlah,
            'total_bayar' => ($request->jumlah * $data->harga_jual),
            'status' => 1
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
    public function update(Request $request, string $id)
    {
        //
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

        $data->status = 2;
        $updated = $data->save();

        return response()->json([
            'status' => true,
            'message' => 'Sukses Melakukan delete Data',
        ]);
    }
    public function data_list()
    {
        $dt = Penjualan::leftJoin('stok_barang as sb', 'sb.stok_barang_id', '=', 'penjualan.stok_barang_id')
        ->select('penjualan.*', 'sb.nama','sb.harga_jual')->where('penjualan.status',1)
        ->orderBy('penjualan.penjualan_id', 'desc')
        ->get();

        $data = array();
        $start = 0;
        foreach ($dt as $key => $value) {
            $td = array();
            $td['no'] = ++$start;
            $td['penjualan_id'] = $value->penjualan_id ?? '-';
            $td['stok_barang_id'] = $value->stok_barang_id ?? '-';
            $td['nama'] = $value->nama ?? '-';
            $td['harga_jual'] = $value->harga_jual ?? '-';
            $td['jumlah'] = $value->jumlah ?? '-';
            $td['total_bayar'] = $value->total_bayar ?? '-';
            $td['actions'] ='<a href="javascript:void(0)" onclick="hapus(\''.$value->penjualan_id.'\')" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">
                                <i class="la la-trash-o"></i>
                            </a>';
            $data[] = $td;
        }
        return response()->json(['data' => $data]);
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
}
