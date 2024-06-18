<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Stok_barang;
use App\Models\Karyawan;
use App\Models\Piutang;
use App\Models\Saldo;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Worksheet\ColumnDimension;

use Illuminate\Support\Facades\Validator;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $karyawan=Karyawan::all();

        $no = Penjualan::select('no_transaksi')
        ->orderBy('penjualan_id', 'desc')
        ->limit(1)
        ->first();
        $month                 = date('m');
        $tahun                 = date('Y');

        if (isset($no->no_transaksi)) {
            $order= $no->no_transaksi;
            $pecah = explode("/",  $order);
            $seq = $pecah[0];
            $no_order = $seq + 1;
        } else {
            $no_order = 1;
        }
        $no_transaksi = sprintf("%04s", $no_order) . '/KSR/' . $tahun; 
        return view("page.penjualan",compact('no_transaksi','karyawan'));
    }
    public function detail()
    {
        return view("page.penjualan_detail");
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
            'no_transaksi' => 'required',
            'pelanggan' => 'required'

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memasukkan data',
                'data' => $validator->errors()
            ]);
        }
        $pesan = json_decode($request->produk, true);
        foreach ($pesan as $produk) {
            $barang = Stok_barang::find($produk['barang_id']); 
            $barang->stok -= $produk['jumlah'];
            $barang->save();

            if ($barang->stok < $produk['jumlah']) { 
                return response()->json([
                    'status' => false,
                    'message' => 'Stok tidak mencukupi'
                ]);
            }
        }

        $data = Penjualan::create([
            'no_transaksi' => $request->no_transaksi,
            'pelanggan' => $request->pelanggan,
            'produk' => $request->produk,
            'total_bayar' => $request->total_bayar,
            'cash' => $request->cash,
            'keterangan' => $request->keterangan,
            'karyawan_id' => isset($request->karyawan_id)? $request->karyawan_id:null,
            'tanggal' => Carbon::now()->format('Y-m-d')

        ]);
        
        $karyawan=$request->karyawan_id;
        if($request->pelanggan == 'hutang'){
            if(empty($karyawan)){
                return response()->json([
                    'status' => false,
                    'message' => 'Anda belum memilih karyawan',
                ]);
            }
        }

        if($request->pelanggan == 'anggota koperasi'){
            if(empty($karyawan)){
                return response()->json([
                    'status' => false,
                    'message' => 'Anda belum memilih karyawan',
                ]);
            }
            $saldo = Saldo::where('karyawan_id', $karyawan)->first();
            $hasil=$request->total_bayar - ($saldo->saldo);

            if($saldo->saldo >= $request->total_bayar){
                $saldo->saldo -= $request->total_bayar; 
                $saldo->save();
            } else{
                $bayar=$request->cash;
                $saldo->saldo = 0; 
                $saldo->save();
                
                if($request->cash < $hasil){
                    $hutang = $hasil - $request->cash;
                        $piutang = Piutang::create([
                            'karyawan_id' => $karyawan,
                            'jumlah' => $hutang,
                            'no_transaksi' =>$request->no_transaksi
                        ]);
                }
            }
        }

        if ($data) {
            return response()->json([
                'status' => true,
                'message' => 'Sukses Memasukkan Data'
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Penjualan::find($id);

        if (empty($data)) {
            return response()->json([
                'status' => false,
                'message' => 'Data gagal ditemukan'
            ], 404);
        }
        $perbedaan = $data->jumlah;
        $barang = Stok_barang::find($data->stok_barang_id);
        $barang->stok += $perbedaan; 
        $barang->save();

        $data->status = 2;
        $updated = $data->save();

        return response()->json([
            'status' => true,
            'message' => 'Sukses Melakukan delete Data',
        ]);
    }
    public function data_list(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return response()->json(['data' => []]);
        }

        $dt = Stok_barang::whereIn("stok_barang_id", $ids)->get();

        $data = array();
        $total_bayar = 0;
        $start = 0;
        foreach ($dt as $key => $value) {
            $td = array();
            $td['no'] = ++$start;
            $td['stok_barang_id'] = $value->stok_barang_id ?? '-';
            $td['nama'] = $value->nama ?? '-';
            $td['harga_jual'] = $value->harga_jual ?? '-';
            $td['jumlah'] = 1;
            $td['total_bayar'] = $value->harga_jual;
            $total_bayar += $value->harga_jual;
            $data[] = $td;
        }
        return response()->json(['data' => $data, 'total_bayar' => $total_bayar]);
    }
    public function getBarcode(Request $request)
    {
        $text = $request->searchtext;
        $barang = Stok_barang::select('stok_barang_id', 'barcode','nama')
            ->where(function ($query) use ($text) {
                $query->where('stok_barang_id', 'like', '%' . strtolower($text) . '%')
                    ->orWhere('barcode', 'like', '%' . strtolower($text) . '%')
                    ->orWhere('nama', 'like', '%' . strtolower($text) . '%');
        })->get();

        $output = [];
        $output['total_data'] = count($barang);
        
        foreach ($barang as $list) {
            $row['stok_barang_id'] = $list->stok_barang_id;
            $row['barcode'] = $list->barcode;
            $row['nama'] = $list->nama;
            $output['items'][] = $row;
        }

        return response()->json($output);
    }
    public function getSaldo(Request $request)
    {
        $karyawan_id = $request->karyawan_id;

        if ($karyawan_id) {
            $dt = Saldo::where('karyawan_id', $karyawan_id)->first();

            if ($dt) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'saldo' => $dt->saldo
                    ]
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'data' => [
                'saldo' => 0
            ]
        ]);
    }
    public function detail_list(Request $request)
    {
        $param = $request->input('pelanggan');
        $dt = Penjualan::leftJoin('karyawan as k', 'k.karyawan_id', '=', 'penjualan.karyawan_id')
        ->select('penjualan.*', 'k.nama')
        ->where('pelanggan', $param)
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
                        $td['no_transaksi'] = '<span class="m-badge m-badge--rounded text-white bg-info">' . $penjualan->no_transaksi . '</span>';
                        $td['nama_barang'] = $barang->nama ?? '-';
                        $td['jumlah'] = $produk['jumlah'] ?? '-';
                        $td['tanggal'] = $penjualan->tanggal ?? '-';
                        $td['keterangan'] = $penjualan->keterangan ?? '-';
                        $td['pic'] = $penjualan->nama ?? '-';
                        $total_bayar = $produk['jumlah'] * $barang->harga_jual;
                        $td['total_bayar'] = isset($total_bayar) ? 'Rp ' . number_format($total_bayar, 0, ',', '.') : '-';
                        
                        $data[] = $td;
                    }
                }
            }
            return response()->json(['data' => $data]);
    }
    public function exportlaporan(Request $request)
    {
       
        $data = Penjualan::leftJoin('karyawan as k', 'k.karyawan_id', '=', 'penjualan.karyawan_id')
            ->select('penjualan.*', 'k.nama')
            ->where('pelanggan', 'pengambilan barang')
            ->whereMonth('tanggal', date('m'))
            ->whereYear('tanggal', date('Y'))
            ->get();
       

        $penjualan_details = [];

        foreach ($data as $penjualan) {
            $pesanan = json_decode($penjualan->produk, true);
            foreach ($pesanan as $produk) {
                $barang = Stok_barang::where('stok_barang_id', $produk['barang_id'])->first();
                $penjualan_details[] = [
                    'no_transaksi' => $penjualan->no_transaksi,
                    'pelanggan' => $penjualan->pelanggan,
                    'nama_barang' => $barang->nama,
                    'jumlah' => $produk['jumlah'],
                    'harga_jual' => $barang->harga_jual,
                    'tanggal' => $penjualan->tanggal,
                    'keterangan' => $penjualan->keterangan,
                    'pic' => $penjualan->nama,
                    'total_bayar' => $produk['jumlah'] * $barang->harga_jual,
                ];
            }
        }
        // =================Rekapitulasi======================
       $data_group = Penjualan::leftJoin('karyawan as k', 'k.karyawan_id', '=', 'penjualan.karyawan_id')
            ->select('penjualan.*', 'k.nama')
            ->where('pelanggan', 'pengambilan barang')
            ->whereMonth('tanggal', date('m'))
            ->whereYear('tanggal', date('Y'))
            ->get();

        $penjualan_details_group = [];

        foreach ($data_group as $penjualan_group) {
            $pesanan = json_decode($penjualan_group->produk, true);
            foreach ($pesanan as $produk) {
                $barang_group = Stok_barang::where('stok_barang_id', $produk['barang_id'])->first();
                $key = $produk['barang_id'];

               if (!isset($penjualan_details_group[$key])) {
                $penjualan_details_group[$key] = [
                    'nama_barang_group' => $barang_group->nama,
                    'harga_jual_group' => $barang_group->harga_jual,
                    'jumlah_group' => 0, 
                    'total_bayar_group' => 0, 
                ];
            }
            $penjualan_details_group[$key]['jumlah_group'] += $produk['jumlah'];
            $penjualan_details_group[$key]['total_bayar_group'] += $produk['jumlah'] * $barang_group->harga_jual;
            }
        }

        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        $month = $months[(int)date('m')];
        $year = date('Y');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'INVOICE PANTRY & RUMAH TANGGA POLITEKNIK CALTEX RIAU');
        $sheet->mergeCells('A1:I1');

        $sheet->setCellValue('A3', 'Bulan ' . $month . ' ' . $year);
        $sheet->mergeCells('A3:C3');

        $sheet->setCellValue('J3', 'Rekapitulasi Invoice RT PCR Bulan ' . $month . ' ' . $year);
        $sheet->mergeCells('J3:M3');

        $sheet->setCellValue('A5', 'No');
        $sheet->setCellValue('B5', 'Tanggal');
        $sheet->setCellValue('C5', 'Keterangan');
        $sheet->setCellValue('D5', 'PIC');
        $sheet->setCellValue('E5', 'Nama Barang');
        $sheet->setCellValue('F5', 'Jumlah');
        $sheet->setCellValue('G5', 'Harga Satuan');
        $sheet->setCellValue('H5', 'Total');

        $sheet->setCellValue('J5', 'No');
        $sheet->setCellValue('K5', 'Nama Barang');
        $sheet->setCellValue('L5', 'Jumlah');
        $sheet->setCellValue('M5', 'Harga Satuan');
        $sheet->setCellValue('N5', 'Total');

        $row = 6; 
        foreach ($penjualan_details as $index => $detail) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $detail['tanggal']);
            $sheet->setCellValue('C' . $row, $detail['keterangan']);
            $sheet->setCellValue('D' . $row, $detail['pic']);
            $sheet->setCellValue('E' . $row, $detail['nama_barang']);
            $sheet->setCellValue('F' . $row, $detail['jumlah']);
            $sheet->setCellValue('G' . $row, $detail['harga_jual']);
            $sheet->setCellValue('H' . $row, $detail['jumlah'] * $detail['harga_jual']);
            $row++;
        }

        $row = 6; 
        foreach ($penjualan_details_group as $index => $detail) {
            $sheet->setCellValue('J' . $row, $index + 1);
            $sheet->setCellValue('K' . $row, $detail['nama_barang_group']);
            $sheet->setCellValue('L' . $row, $detail['jumlah_group']);
            $sheet->setCellValue('M' . $row, $detail['harga_jual_group']);
            $sheet->setCellValue('N' . $row, $detail['total_bayar_group']);
            $row++;
        }

        $sheet->getColumnDimension('A')->setWidth(5); 
        $sheet->getColumnDimension('B')->setWidth(15); 
        $sheet->getColumnDimension('C')->setWidth(20); 
        $sheet->getColumnDimension('D')->setWidth(20); 
        $sheet->getColumnDimension('E')->setWidth(25); 
        $sheet->getColumnDimension('F')->setWidth(10);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(10);

        $sheet->getColumnDimension('J')->setWidth(5); 
        $sheet->getColumnDimension('K')->setWidth(25); 
        $sheet->getColumnDimension('L')->setWidth(10); 
        $sheet->getColumnDimension('M')->setWidth(15); 
        $sheet->getColumnDimension('N')->setWidth(10); 

        $sheet->getStyle('A1:I1')->applyFromArray([
            'font' => [
                'color' => [
                    'rgb' => '000000',
                ],
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getStyle('A5:H5')->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => [
                    'rgb' => 'ADD8E6',
                ],
            ],
            'font' => [
                'color' => [
                    'rgb' => '000000',
                ],
                'bold' => true,
            ],
        ]);

        $sheet->getStyle('J5:N5')->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => [
                    'rgb' => 'ADD8E6',
                ],
            ],
            'font' => [
                'color' => [
                    'rgb' => '000000',
                ],
                'bold' => true,
            ],
        ]);


        $filename = 'Invoice_penjualan_'. date('d-m-y') . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $filePath = storage_path('app/public/' . $filename);
        $writer->save($filePath);
        
        return Response::download($filePath, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }
}
