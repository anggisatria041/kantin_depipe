<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sewa;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SewaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenant=DB::connection('pgsql')->table('users')->select()->where('role','tenant')->get();
        return view("page.sewa",compact('tenant'));
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
            'tgl_sewa' => 'required|date',
            'tgl_berakhir' => 'required|date',
            'harga' => 'required',
            'level' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memasukkan data',
                'data' => $validator->errors()
            ]);
        }

        $data = new Sewa;
        $data->tenant_id = $request->karyawan_id;
        $data->tgl_sewa = $request->tgl_sewa;
        $data->tgl_berakhir = $request->tgl_berakhir;
        $data->harga = $request->harga;
        $data->level = $request->level;
        $data->status = "1";

        if ($data->save()) {
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
    public function edit( $id)
    {
        $sewa = Sewa::findOrFail($id);
        return response()->json(['data' => $sewa], 200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->sewa_id;
        $data = Sewa::find($id);

        $rules = [
            'tgl_sewa' => 'required|date',
            'tgl_berakhir' => 'required|date',
            'harga' => 'required',
            'level' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengubah data',
                'data' => $validator->errors()
            ]);
        }

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data Sewa tidak ditemukan',
            ]);
        }

        $data->tenant_id = $request->karyawan_id;
        $data->tgl_sewa = $request->tgl_sewa;
        $data->tgl_berakhir = $request->tgl_berakhir;
        $data->harga = $request->harga;
        $data->level = $request->level;
        $updated = $data->save();

        if ($updated) {
            return response()->json([
                'status' => true,
                'message' => 'Sukses mengubah Data',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengubah data',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Sewa::find($id);

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
        $users = DB::connection('pgsql')->table('users')->where('role', 'tenant')->get();

        $sewa = DB::connection('mysql')->table('sewa')->where('status', 1)->orderBy('tgl_sewa', 'desc')->get();

        $joinResult = [];
        foreach ($sewa as $item) {
            foreach ($users as $user) {
                if ($item->tenant_id == $user->id) {
                    $resultItem = (object) array_merge((array) $item, (array) $user);
                    $joinResult[] = $resultItem;
                }
            }
        }

        $data = array();
        $start = 0;
        foreach ($joinResult as $key => $value) {
            $td = array();
            $td['no'] = ++$start;
            $td['sewa_id'] = $value->sewa_id ?? '-';
            $td['tgl_sewa'] = $value->tgl_sewa ?? '-';
            $td['nama'] = $value->nama ?? '-';
            $td['tgl_berakhir'] = $value->tgl_berakhir ?? '-';
            $td['harga'] = isset($value->harga) ? 'Rp ' . number_format($value->harga, 0, ',', '.') : '-';
            $td['level'] = $value->level ?? '-';
            $td['actions'] ='<a href="javascript:void(0)" onclick="edit(\''.$value->sewa_id.'\')" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit">
                                <i class="la la-edit"></i>
                            </a>
                            <a href="javascript:void(0)" onclick="hapus(\''.$value->sewa_id.'\')" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">
                                <i class="la la-trash-o"></i>
                            </a>';
            $data[] = $td;
        }
        return response()->json(['data' => $data]);
    }
}
