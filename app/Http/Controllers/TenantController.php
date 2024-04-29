<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("page.tenant");
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
            'nama' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
            'nik' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memasukkan data',
                'data' => $validator->errors()
            ]);
        }
        if ($request->hasFile('logo')) {
            $gambarPath = $request->file('logo')->store('', 'public'); 
            $logo = $gambarPath;
        } else {
            $logo = null;
        }

        $data = User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->input('password')),
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'nik' => $request->nik,
            'logo' => $logo,
            'role' => 'tenant'
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
        $data = User::findOrFail($id);
        return response()->json(['data' => $data], 200);
    }

    public function password(string $id)
    {
        $data = User::findOrFail($id);
        return response()->json(['data' => $data], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $data = User::find($id);

        $rules = [
            'nama' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'alamat' => 'required',
            'no_hp' => 'required',
            'nik' => 'required'
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
        if ($request->hasFile('logo')) {
            $gambarPath = $request->file('logo')->store('', 'public'); 
            $logo = $gambarPath;
            $data->update([
                'logo' => $logo
            ]);
        }

        $data->update([
            'nama' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'nik' => $request->nik,
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
        $data = User::find($id);

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
        $dt = User::where('role','tenant')->orderBy('id', 'desc')->get();
        $data = array();
        $start = 0;
        foreach ($dt as $key => $value) {
            $td = array();
            $td['no'] = ++$start;
            $td['id'] = $value->id ?? '-';
            $td['nama'] = $value->nama ?? '-';
            $td['alamat'] = $value->alamat ?? '-';
            $td['email'] = $value->email ?? '-';
            $td['no_hp'] = $value->no_hp ?? '-';
            $td['nik'] = $value->nik ?? '-';
            // $td['actions'] ='';
            $data[] = $td;
        }
        return response()->json(['data' => $data]);
    }
    public function updatePassword(Request $request)
    {
        $id = $request->id;
        $data = User::find($id);
        $data->update([
            'password' => Hash::make($request->input('new_password')),
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
}
