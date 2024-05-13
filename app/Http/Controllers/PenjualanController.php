<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stok_barang;
use Illuminate\Support\Facades\Validator;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("page.penjualan");
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
        $dt = Stok_barang::orderBy('stok_barang_id', 'desc')->get();
        $data = array();
        $start = 0;
        foreach ($dt as $key => $value) {
            $td = array();
            $td['no'] = ++$start;
            $td['stok_barang_id'] = $value->stok_barang_id ?? '-';
            $td['nama'] = $value->nama ?? '-';
            $td['barcode'] = $value->barcode ?? '-';
            $td['jumlah'] = $value->jumlah ?? '-';
            $td['satuan'] = $value->satuan ?? '-';
            $td['harga'] = $value->harga ?? '-';
            $td['actions'] ='<a href="javascript:void(0)" onclick="edit(\''.$value->stok_barang_id.'\')" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit">
                                <i class="la la-edit"></i>
                            </a>
                            <a href="javascript:void(0)" onclick="hapus(\''.$value->stok_barang_id.'\')" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">
                                <i class="la la-trash-o"></i>
                            </a>';
            $data[] = $td;
        }
        return response()->json(['data' => $data]);
    }
}
