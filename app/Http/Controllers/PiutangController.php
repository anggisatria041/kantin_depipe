<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Piutang;
use App\Models\Penjualan;
use App\Models\Stok_barang;
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
        $data = Piutang::where('karyawan_id',$id);
        $dt = Penjualan::where('karyawan_id',$id);

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
        $dt = Penjualan::leftJoin('karyawan as k', 'k.karyawan_id', '=', 'penjualan.karyawan_id')
        ->leftJoin(DB::raw('(SELECT karyawan_id, SUM(jumlah) as total_piutang FROM piutang WHERE MONTH(created_at) = ' . date('m') . ' AND YEAR(created_at) = ' . date('Y') . ' GROUP BY karyawan_id) as p'), 'p.karyawan_id', '=', 'k.karyawan_id')
        ->select('k.karyawan_id', 'k.nama',
            DB::raw('SUM(CASE WHEN penjualan.pelanggan = "hutang" THEN penjualan.total_bayar ELSE 0 END) as total_penjualan'),
            DB::raw('COALESCE(p.total_piutang, 0) as total_piutang'),
            DB::raw('SUM(CASE WHEN penjualan.pelanggan = "hutang" THEN penjualan.total_bayar ELSE 0 END) + COALESCE(p.total_piutang, 0) as total_bayar')
        )
        ->whereMonth('penjualan.tanggal', date('m'))
        ->whereYear('penjualan.tanggal', date('Y'))
        ->whereNotNull('k.karyawan_id')
        ->groupBy('k.karyawan_id', 'k.nama', 'p.total_piutang')
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
    public function detail_list()
    {
        $dt = Penjualan::leftJoin('karyawan as k', 'k.karyawan_id', '=', 'penjualan.karyawan_id')
            ->select('penjualan.*', 'k.nama', 'k.karyawan_id')
            ->where('pelanggan','hutang')
            ->whereMonth('tanggal', date('m'))
            ->whereYear('tanggal', date('Y'))
            ->orderBy('penjualan.penjualan_id', 'desc')
            ->get();

        $data = array();
        $start = 0;
        foreach ($dt as $penjualan) {
            $produks = json_decode($penjualan->produk, true); 
            
            foreach ($produks as $produk) {
                $barang = Stok_barang::where('stok_barang_id', $produk['barang_id'])->first();
                if ($barang) {
                    $td = array();
                    $td['no'] = ++$start;
                    $td['nama'] = $penjualan->nama ?? '-';
                    $td['no_transaksi'] = '<span class="m-badge m-badge--rounded text-white bg-info">' . $penjualan->no_transaksi . '</span>';
                    $td['nama_barang'] = $barang->nama ?? '-';
                    $td['jumlah'] = $produk['jumlah'] ?? '-';
                    $td['tanggal'] = $penjualan->tanggal ?? '-';
                    $total_bayar = $produk['jumlah'] * $barang->harga_jual;
                    $td['total_bayar'] = isset($total_bayar) ? 'Rp ' . number_format($total_bayar, 0, ',', '.') : '-';
                    
                    $data[] = $td;
                }
            }
        }
        
        return response()->json(['data' => $data]);
    }

    public function detail_list_saldo()
    {
        $dt = Piutang::leftJoin('karyawan as k', 'k.karyawan_id', '=', 'piutang.karyawan_id')
            ->select('k.karyawan_id', 'k.nama','piutang.*')
            ->whereMonth('piutang.created_at', date('m'))
            ->whereYear('piutang.created_at', date('Y'))
            ->get();


        $data = array();
        $start = 0;
        foreach ($dt as $key => $value) {
            $td = array();
            $td['no'] = ++$start;
            $td['nama'] = $value->nama ?? '-';
            $td['tanggal'] =$value->created_at->format('Y-m-d');
            $td['no_transaksi'] = '<span class="m-badge m-badge--rounded text-white bg-info">' . $value->no_transaksi . '</span>';
            $td['piutang'] = isset($value->jumlah) ? 'Rp ' . number_format($value->jumlah, 0, ',', '.') : '-';
            $td['actions'] ='<a href="javascript:void(0)" onclick="hapus(\''.$value->karyawan_id.'\')" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">
                                <i class="la la-trash-o"></i>
                            </a>';
            $data[] = $td;
        }
        return response()->json(['data' => $data]);
    }

}
