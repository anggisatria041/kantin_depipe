<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sewa;

class HistoriSewaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("page.histori_sewa");
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
        //
    }
    public function data_list()
    {
        $dt = Sewa::where('status',2)->orderBy('tgl_sewa', 'desc')->get();
        $data = array();
        $start = 0;
        foreach ($dt as $key => $value) {
            $td = array();
            $td['no'] = ++$start;
            $td['sewa_id'] = $value->sewa_id ?? '-';
            $td['tgl_sewa'] = $value->tgl_sewa ?? '-';
            $td['tgl_berakhir'] = $value->tgl_berakhir ?? '-';
            $td['harga'] = $value->harga ?? '-';
            $td['level'] = $value->level ?? '-';
            $data[] = $td;
        }
        return response()->json(['data' => $data]);
    }
}
