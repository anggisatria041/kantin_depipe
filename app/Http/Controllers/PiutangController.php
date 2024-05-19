<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Piutang;
use App\Models\Penjualan;
use Illuminate\Support\Facades\DB;


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
        $data = Penjualan::where('karyawan_id',$id);

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
        $dt = Penjualan::leftJoin('karyawan as k', 'k.karyawan_id', '=', 'penjualan.karyawan_id')
            ->select('k.karyawan_id', 'k.nama', DB::raw('SUM(penjualan.total_bayar) as total_bayar'))
            ->whereNotNull('penjualan.karyawan_id')
            ->groupBy('k.karyawan_id', 'k.nama')
            ->get();


        $data = array();
        $start = 0;
        foreach ($dt as $key => $value) {
            $td = array();
            $td['no'] = ++$start;
            $td['nama'] = $value->nama ?? '-';
            $td['total_bayar'] = isset($value->total_bayar) ? 'Rp ' . number_format($value->total_bayar, 0, ',', '.') : '-';
            $td['actions'] ='<a href="javascript:void(0)" onclick="hapus(\''.$value->karyawan_id.'\')" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">
                                <i class="la la-trash-o"></i>
                            </a>';
            $data[] = $td;
        }
        return response()->json(['data' => $data]);
    }
}
