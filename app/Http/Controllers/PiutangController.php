<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Piutang;
use App\Models\Penjualan;


class PiutangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("page.piutang");
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
        //
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
        $data = Piutang::findOrFail($id);
        return response()->json(['data' => $data], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->piutang_id;
        $data = Piutang::find($id);

        $data->update([
            'piutang' => $request->piutang
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
        $data = Piutang::where('karyawan_id',$id)->first();
        $dt = Penjualan::where('karyawan_id',$id)->where('pelanggan','hutang');

        if (empty($data)) {
            return response()->json([
                'status' => false,
                'message' => 'Data gagal ditemukan'
            ], 404);
        }

        $data->delete();
        $dt->delete();


        return response()->json([
            'status' => true,
            'message' => 'Sukses Melakukan delete Data',
        ]);
    }
    public function data_list()
    {
        $dt = Piutang::leftJoin('karyawan as k', 'k.karyawan_id', '=', 'piutang.karyawan_id')
        ->select('piutang.*', 'k.nama','k.karyawan_id')
        ->orderBy('piutang.piutang_id', 'desc')
        ->get();

        $data = array();
        $start = 0;
        foreach ($dt as $key => $value) {
            $td = array();
            $td['no'] = ++$start;
            $td['nama'] = $value->nama ?? '-';
            $td['piutang'] = isset($value->piutang) ? 'Rp ' . number_format($value->piutang, 0, ',', '.') : '-';
            $td['actions'] ='<a href="javascript:void(0)" onclick="edit(\''.$value->piutang_id.'\')" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit">
                                <i class="la la-edit"></i>
                            </a>
                            <a href="javascript:void(0)" onclick="hapus(\''.$value->karyawan_id.'\')" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">
                                <i class="la la-trash-o"></i>
                            </a>';
            $data[] = $td;
        }
        return response()->json(['data' => $data]);
    }
}
