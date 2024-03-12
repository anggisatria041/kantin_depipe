<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sewa;
use Illuminate\Support\Facades\Validator;

class SewaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("page.sewa");
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
        $dt = Sewa::all();
        $data = array();
        $start = 0;
        foreach ($dt as $key => $value) {
            $td = array();
            $td['no'] = ++$start;
            $td['tgl_sewa'] = $value->tgl_sewa ?? '-';
            $td['tgl_berakhir'] = $value->tgl_berakhir ?? '-';
            $td['harga'] = $value->harga ?? '-';
            $td['status'] = $value->status ?? '-';
            $td['actions'] = '';
            $data[] = $td;
        }
        return response()->json(['data' => $data]);
    }
}
