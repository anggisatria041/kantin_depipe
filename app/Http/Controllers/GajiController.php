<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gaji;
use App\Models\Karyawan;

use Illuminate\Support\Facades\Validator;

class GajiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $karyawan=Karyawan::all();
        return view("page.gaji",compact("karyawan"));
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
            'karyawan_id' => 'required',
            'jumlah' => 'required',
            'tanggal' => 'required|date',
            'status' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memasukkan data',
                'data' => $validator->errors()
            ]);
        }

         $data = Gaji::create([
            'karyawan_id' => $request->karyawan_id,
            'jumlah' => $request->jumlah,
            'tanggal' => $request->tanggal,
            'status' => $request->status
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
        $data = Gaji::findOrFail($id);
        return response()->json(['data' => $data], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->gaji_id;
        $data = Gaji::find($id);

        $rules = [
            'karyawan_id' => 'required',
            'jumlah' => 'required',
            'tanggal' => 'required|date',
            'status' => 'required',
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
                'message' => 'Data Karyawan tidak ditemukan',
            ]);
        }
         $data->update([
            'karyawan_id' => $request->karyawan_id,
            'jumlah' => $request->jumlah,
            'tanggal' => $request->tanggal,
            'status' => $request->status
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
        $data = Gaji::find($id);

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
        $dt = Gaji::leftJoin('karyawan as k', 'k.karyawan_id', '=', 'gaji.karyawan_id')
        ->select('gaji.*', 'k.nama')
        ->orderBy('gaji.gaji_id', 'desc')
        ->get();

        $data = array();
        $start = 0;
        foreach ($dt as $key => $value) {
            $td = array();
            $td['no'] = ++$start;
            $td['gaji_id'] = $value->gaji_id ?? '-';
            $td['nama'] = $value->nama ?? '-';
            $td['jumlah'] = $value->jumlah ?? '-';
            $td['tanggal'] = $value->tanggal ?? '-';
            $td['status'] = $value->status ?? '-';
            $td['actions'] ='<a href="javascript:void(0)" onclick="edit(\''.$value->gaji_id.'\')" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit">
                                <i class="la la-edit"></i>
                            </a>
                            <a href="javascript:void(0)" onclick="hapus(\''.$value->gaji_id.'\')" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">
                                <i class="la la-trash-o"></i>
                            </a>';
            $data[] = $td;
        }
        return response()->json(['data' => $data]);
    }
}
