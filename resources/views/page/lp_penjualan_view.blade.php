<?php 
$no = 1;

$exportData = '<style>
    #data a, #data a:visited, #data a:hover, #data a:active {
        color: inherit;
        text-decoration: none;
    }
    .table, #data {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
        font-size: 11px;
    }
    .table, #data td, #data th {
        border: 1px solid #ddd;
        padding: 4px;
    }
    #data tr:nth-child(even) {background-color: #f2f2f2;}
    #data tr:hover {background-color: #ddd;}
    #data th {
        padding-top: 12px;
        padding-bottom: 12px;
        background-color: #4CAF50;
        color: white;
    }
    .table {
        overflow-x: auto;
        overflow-y: scroll;
        height: 500px;
        display: block;
    }
    .table2 {
        width: 1200px;
        display: block;
    }
    .tbody {
        display: table;
        width: 100%;
    }
    .tbody2 {
        display: table;
        width: 100%;
    }
    .table th, td {
        white-space: nowrap;
    }
    .tengah {
        text-align: center;
    }
    .kanan {
        text-align: center;
    }
</style>';
$exportData .= '<table width="100%"><tbody class="tbody2">
    <tr>
        <td colspan="2" class="tengah"><h2>Penjualan Report</h2></td>
    </tr>
    <tr>
        <td width="10%">Tanggal Report</td>
        <td>: ' . date('d-M-Y') . '</td>
    </tr>
</tbody></table>
<table class="table" border="1" width="100%" id="data">
    <tbody class="tbody">
        <tr>
            <th>No.</th>
            <th>No Transaksi</th>
            <th>Nama Barang</th>
            <th>Jumlah</th>
            <th>Tanggal</th>
            <th>Total Bayar</th>
            <th>Transaksi</th>
        </tr>';

if (!empty($penjualan_details)) {
    foreach ($penjualan_details as $detail) {
        $exportData .= '<tr>
            <td class="tengah">' . $no . '.</td>
            <td>' . ($detail['no_transaksi'] ? $detail['no_transaksi'] : '-') . '</td>
            <td>' . $detail['nama_barang'] . '</td>
            <td>' . $detail['jumlah'] . '</td>
            <td>' . $detail['tanggal'] . '</td>
            <td>' . $detail['total_bayar'] . '</td>
            <td>' . $detail['pelanggan'] . '</td>
        </tr>';
        $no++;
    }
    $exportData .= '</tbody></table>';
} else {
    $exportData .= '<tr><td colspan="6" align="center">Data Belum Ada</td></tr></tbody></table>';
}

echo $exportData;
?>
