<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Stok_barang;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Worksheet\ColumnDimension;


class Lp_PenjualanController extends Controller
{
    public function index()
    {
        return view("page.lp_penjualan");
        
    }

    public function getlaporan(Request $request)
    {
        $pelanggan = $request->pelanggan;
        $tgl_mulai = $request->tgl_mulai;
        $tgl_sampai = $request->tgl_sampai;

        if($pelanggan){
            $data = Penjualan::where('pelanggan', $pelanggan)
            ->whereBetween('tanggal', [$tgl_mulai, $tgl_sampai])
            ->get();
        }else{
            $data = Penjualan::whereBetween('tanggal', [$tgl_mulai, $tgl_sampai])
            ->get();
        }
        

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
                    'tanggal' => $penjualan->tanggal,
                    'total_bayar' => $produk['jumlah'] * $barang->harga_jual,
                ];
            }
        }

        $view = view('page.lp_penjualan_view', compact('penjualan_details'))->render();

        return response()->json([
            'status' => true,
            'laporan' => $view
        ]);

    }
    public function exportlaporan(Request $request)
    {
        $pelanggan = $request->pelanggan;
        $tgl_mulai = $request->tgl_mulai;
        $tgl_sampai = $request->tgl_sampai;

        if ($pelanggan) {
            $data = Penjualan::where('pelanggan', $pelanggan)
                ->whereBetween('tanggal', [$tgl_mulai, $tgl_sampai])
                ->get();
        } else {
            $data = Penjualan::whereBetween('tanggal', [$tgl_mulai, $tgl_sampai])
                ->get();
        }

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
                    'tanggal' => $penjualan->tanggal,
                    'total_bayar' => $produk['jumlah'] * $barang->harga_jual,
                ];
            }
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'No Transaksi');
        $sheet->setCellValue('C1', 'Pelanggan');
        $sheet->setCellValue('D1', 'Nama Barang');
        $sheet->setCellValue('E1', 'Jumlah');
        $sheet->setCellValue('F1', 'Tanggal');
        $sheet->setCellValue('G1', 'Total Bayar');

        $row = 2;
        foreach ($penjualan_details as $index => $detail) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $detail['no_transaksi']);
            $sheet->setCellValue('C' . $row, $detail['pelanggan']);
            $sheet->setCellValue('D' . $row, $detail['nama_barang']);
            $sheet->setCellValue('E' . $row, $detail['jumlah']);
            $sheet->setCellValue('F' . $row, $detail['tanggal']);
            $sheet->setCellValue('G' . $row, $detail['total_bayar']);
            $row++;
        }
        $sheet->getColumnDimension('A')->setWidth(5); 
        $sheet->getColumnDimension('B')->setWidth(15); 
        $sheet->getColumnDimension('C')->setWidth(25); 
        $sheet->getColumnDimension('D')->setWidth(25); 
        $sheet->getColumnDimension('E')->setWidth(10); 
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getStyle('A1:G1')->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => [
                    'rgb' => '4CAF50', // Warna hijau
                ],
            ],
            'font' => [
                'color' => [
                    'rgb' => 'FFFFFF', // Warna teks putih
                ],
            ],
        ]);

        $filename = 'Laporan_penjualan_'. date('d-m-y') . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $filePath = storage_path('app/public/' . $filename);
        $writer->save($filePath);
        
        return Response::download($filePath, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }
}
