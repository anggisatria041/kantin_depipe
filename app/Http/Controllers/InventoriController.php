<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventori;
use Illuminate\Support\Facades\Validator;

class InventoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("page.inventori");
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
            'nama_barang' => 'required',
            'jumlah' => 'required',
            'harga_satuan' => 'required',
            'tanggal_masuk' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memasukkan data',
                'data' => $validator->errors()
            ]);
        }

         $data = Inventori::create([
            'nama_barang' => $request->nama_barang,
            'jumlah' => $request->jumlah,
            'harga_satuan' => $request->harga_satuan,
            'tanggal_masuk' => $request->tanggal_masuk,
            'total_bayar' => ($request->jumlah * $request->harga_satuan)
        ]);

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
            'nama_barang' => 'required',
            'jumlah' => 'required',
            'harga_satuan' => 'required',
            'tanggal_masuk' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Semua Data Harus Terisi',
                'data' => $validator->errors()
            ]);
        }
        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data Inventori tidak ditemukan',
            ]);
        }
         $data->update([
            'nama_barang' => $request->nama_barang,
            'jumlah' => $request->jumlah,
            'harga_satuan' => $request->harga_satuan,
            'tanggal_masuk' => $request->tanggal_masuk,
            'total_bayar' => ($request->jumlah * $request->harga_satuan)
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
        $dt = Inventori::orderBy('inventori_id', 'desc')->get();
        $data = array();
        $start = 0;
        foreach ($dt as $key => $value) {
            $td = array();
            $td['no'] = ++$start;
            $td['inventori_id'] = $value->inventori_id ?? '-';
            $td['nama_barang'] = $value->nama_barang ?? '-';
            $td['jumlah'] = $value->jumlah ?? '-';
            $td['harga_satuan'] = $value->harga_satuan ?? '-';
            $td['tanggal_masuk'] = $value->tanggal_masuk ?? '-';
            $td['total_bayar'] = $value->total_bayar ?? '-';
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
