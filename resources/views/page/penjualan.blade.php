@extends('layout.main')
@section('content')
<div class="m-portlet">
    <div class="m-portlet__body  m-portlet__body--no-padding">
    <form class="m-form m-form--fit m-form--label-align-right" action="" method="POST" id="formAdd" enctype="multipart/form-data">
        <div class="row m-row--no-padding m-row--col-separator-xl">
            <div class="col-xl-4">
                <div class="m-widget1">
                    <div class="m-widget1__item">
                        <div class="row m-row--no-padding align-items-center">
                            <div class="col">
                                <h3 class="m-widget1__title">No Transaksi</h3>
                            </div>
                            <div class="col m--align-right">
                                <input type="text" name="no_transaksi" required class="form-control m-input" value="{{ $no_transaksi }}" readonly/>
                            </div>
                        </div>
                    </div>
                    <div class="m-widget1__item">
                        <div class="row m-row--no-padding align-items-center">
                            <div class="col">
                                <h3 class="m-widget1__title">Pelanggan</h3>
                            </div>
                            <div class="col m--align-right">
                                <select name="pelanggan" class="form-control m-input" onchange="transaksi()" id="jenis">
                                    <option value="umum">Umum</option>
                                    <option value="hutang">Hutang</option>
                                    <option value="anggota koperasi">Anggota Koperasi</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="m-widget1">
                    <div class="m-widget1__item">
                        <div class="row m-row--no-padding align-items-center">
                            <div class="col">
                                <h3 class="m-widget1__title">Barcode</h3>
                            </div>
                            <div class="col">
                                <select class="form-control" name="stok_barang_id" id="kode">
                                    <option value=""></option>
                                </select><br>
                            </div>
                        </div>
                    </div>
                    <div class="m-widget1__item">
                        <div class="row m-row--no-padding align-items-center">
                            <div class="col">
                                <h3 class="m-widget1__title">Total Bayar</h3>
                            </div>
                            <div class="col m--align-right">
                                <span class="m-widget1__number m--font-brand" id="total_bayar"></span><br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="m-widget1">
                    <div class="m-widget1__item" id="transaksi_anggota">
                        <div class="row m-row--no-padding align-items-center">
                            <div class="col">
                                <h3 class="m-widget1__title">Karyawan</h3><br>
                                <h3 class="m-widget1__title" id="saldo_title">Saldo</h3>
                            </div>
                            <div class="col">
                                <select name="karyawan_id" class="form-control m-input m-select2" onchange="getSaldo()"  id="karyawan_select">
                                    <option value="">Pilih Karyawan</option>
                                    @foreach ($karyawan as $value)
                                        <option value="{{$value->karyawan_id}}">{{$value->nama}}</option>
                                    @endforeach
                                </select><br>
                                <span class="m-widget1__number m--font-success" id="saldo_number">0</span>
                            </div>
                        </div>
                    </div>
                    <div class="m-widget1__item" id="transaksi_umum">
                        <div class="row m-row--no-padding align-items-center">
                            <div class="col">
                                <h3 class="m-widget1__title">Cash</h3><br>
                                <h3 class="m-widget1__title" id="kembali_title">Kembali</h3>
                            </div>
                            <div class="col m--align-right">
                                <input type="number" name="bayar" required class="form-control m-input" onkeyup="hitungKembalian()" id="bayar"/><br>
                                <span class="m-widget1__number m--font-success" id="kembalian">0,00</span>
                            </div>
                        </div>
                    </div>
                    <div class="m-widget1__item">
                        <div class="row m-row--no-padding align-items-center">
                            <div class="col">
                            </div>
                            <div class="col m--align-right">
                                <a href="#" onclick="simpan()"  class="btn btn-primary btn-sm">
                                    Simpan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
<div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__body">
        <!--begin: Datatable -->
        <div class="m_datatable"></div>
        <!--end: Datatable -->
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script type="text/javascript">
    var method;
    $('#transaksi_anggota').hide();

    document.addEventListener("DOMContentLoaded", () => {
        const kode = document.querySelector("#kode"); 

        if (localStorage.getItem('data') === null) {
            localStorage.setItem('data', '[]');
        }

        let stok_barang_id = JSON.parse(localStorage.getItem('data'));

        kode.onchange = () => {
            if(kode.value=='')return kode.focus();
            stok_barang_id.push(kode.value);
            localStorage.setItem('data', JSON.stringify(stok_barang_id));
            $('#kode').val('').trigger('change');
            $('#kode').select2('open');
            $('.m_datatable').mDatatable().destroy();
            initializeDatatable();
        }

        function initializeDatatable() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $('.m_datatable').mDatatable({
                data: {
                    type: 'remote', 
                    source: {
                        read: {
                            url: "{{ route('penjualan.data_list') }}",
                            method: 'POST', 
                            headers: {
                                'X-CSRF-TOKEN': csrfToken 
                            },
                            dataType: 'json',
                            params: {
                                ids: stok_barang_id 
                            },
                            map: function(raw) {
                                $('#total_bayar').text(raw.total_bayar);
                                return raw.data;
                            }
                        }
                    },
                    pageSize: 10, 
                    serverPaging: true 
                },
                layout: {
                    theme: 'default', 
                    class: '', 
                    scroll: false, 
                    footer: false 
                },
                sortable: false,
                pagination: true,
                search: {
                    input: $('#generalSearch')
                },
                order: [
                    [0, 'desc'] 
                ],
                columns: [{
                    field: "no",
                    title: "No",
                    width: 50,
                    sortable: false,
                    textAlign: 'center',
                }, {
                    field: "nama",
                    title: "Nama Barang"
                }, {
                    field: "harga_jual",
                    title: "Harga"
                }, {
                    field: "jumlah",
                    title: "Jumlah",
                    width: 100,
                    template: function(row) {
                        return '<input type="number" class="form-control quantity-input" data-id="' + row.id + '" value="' + row.jumlah + '" min="1">';
                    }
                }, {
                    field: "total_bayar",
                    title: "Total Bayar",
                    template: function(row) {
                        return '<span class="total-bayar" data-id="' + row.id + '">' + row.total_bayar + '</span>';
                    }
                }]
            });

            $(document).on('input', '.quantity-input', function() {
                var rowId = $(this).data('id');
                var newQuantity = $(this).val();
                var hargaJual = $(this).closest('tr').find('td[data-field="harga_jual"]').text();
                var newTotal = newQuantity * hargaJual;

                $(this).closest('tr').find('.total-bayar[data-id="' + rowId + '"]').text(newTotal);
                var totalBayarSemua = 0;
                $('.total-bayar').each(function() {
                    totalBayarSemua += parseFloat($(this).text());
                });

                $('#total_bayar').text(totalBayarSemua);
            });

            $('#m_form_status').on('change', function () {
                $('.m_datatable').mDatatable().search($(this).val(), 'status');
            });

            $('#m_form_status').selectpicker();
        }

        initializeDatatable();
    });



    function resetForm() {
        $('#m_form_1_msg').hide();
        $('#formAdd')[0].reset();
        $('#kode').val('').trigger('change');
    }
    function save() {
        const formData = $('#formAdd').serialize();
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        const formDataWithToken = formData + '&_token=' + encodeURIComponent(csrfToken);
        $.ajax({
            url: "{{ route('penjualan.store') }}",
            type: "POST",
            data: formDataWithToken,
            dataType: "json",
            success: function(data) {
                if (data.status) {
                    resetForm();
                    $("#total_bayar").html(data.bayar);
                    $('.m_datatable').mDatatable().reload();
                } else {
                    swal({
                        text: data.message,
                        type: "warning",
                        closeOnConfirm: true
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                swal("Oops", "Data gagal disimpan!", "error");
            }
        });
        
    }
    function hapus(id) {
        swal({
            title: "Apakah anda yakin?",
            text: "Anda yakin ingin hapus data ini?",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false,
            confirmButtonText: "<span><i class='flaticon-interface-1'></i><span>Ya, Hapus!</span></span>",
            confirmButtonClass: "btn btn-danger m-btn m-btn--pill m-btn--icon",
            cancelButtonText: "<span><i class='flaticon-close'></i><span>Batal Hapus</span></span>",
            cancelButtonClass: "btn btn-metal m-btn m-btn--pill m-btn--icon"
        }).then(function(e) {
            if (e.value) {
                mApp.blockPage({ //block page
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });

                $.ajax({
                    url: "{{ url('penjualan') }}/" + id, 
                    type: "DELETE", 
                    data: {
                        _token: '{{ csrf_token() }}' 
                    },
                    dataType: "JSON",
                    success: function(data) {
                        if (data.status == true) {
                            $('.m_datatable').mDatatable().reload();
                        } else {
                            swal("Oops", "Data gagal dihapus!", "error");
                        }
                        mApp.unblockPage();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        mApp.unblockPage();
                        swal("Oops", "Data gagal dicancel!", "error");
                    }
                })
            }
        });
    }
    $(document).ready(function () {
        $("#kode").select2({
            width: "100%",
            closeOnSelect: true,
            placeholder: "Cari kode atau nama barang",
            ajax: {
                url: "{{ route('penjualan.getBarcode') }}",
                dataType: "json",
                type: "GET",
                delay: 250,
                data: function(e) {
                    return {
                        searchtext: e.term,
                        page: e.page
                    }
                },
                processResults: function(e, t) {
                    $(e.items).each(function() {
                        this.id = this.stok_barang_id;
                        this.text = `${this.nama}`;
                    });

                    return t.page = t.page || 1, {
                        results: e.items,
                    }
                },
                cache: true
            },
            escapeMarkup: function (markup) {
                return markup;
            },
            minimumInputLength: 1,
            templateResult: function (data) {
                if (data.loading) return data.text;

                var markup =
                    `<div class='select2-result-repository clearfix'>
                        <div class='select2-result-repository_meta'>
                            <div class='select2-result-repository_title'>
                                ${data.barcode} - ${data.nama}
                            </div>
                        </div>
                    </div>`;

                return markup;
            },
            templateSelection: function (data) {
                return data.text;
            }
        });
    });
    function hitungKembalian() {
        var jenis = document.getElementById('jenis').value;
        
        if(jenis == 'umum'){
            var total = parseFloat(document.getElementById('total_bayar').innerText.replace(',', '.'));
            var bayar = parseFloat(document.getElementById('bayar').value);
            var kembalian = bayar - total;
            document.getElementById('kembalian').innerHTML = kembalian.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
        }else{
            var total = parseFloat(document.getElementById('total_bayar').innerText.replace(',', '.'));
            var bayar = parseFloat(document.getElementById('bayar').value);
            var saldo = parseFloat(document.getElementById('saldo_number').innerText.replace(',', '.'));
            var kembalian = (bayar + saldo) - total;
            document.getElementById('kembalian').innerHTML = kembalian.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
        }
    }
    function simpan() {
        const formData = $('#formAdd').serialize();
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        const formDataWithToken = formData + '&_token=' + encodeURIComponent(csrfToken);
       
        $.ajax({
            url: "{{ route('penjualan.update') }}",
            type: "POST",
            data: formDataWithToken,
            dataType: "json",
            success: function(data) {
                if (data.status) {
                    $('#m_modal_6').modal('hide');
                    swal("Berhasil..", "Transaksi berhasil", "success").then(function() {
                        location.reload();
                    });
                } else {
                    swal({
                        text: data.message,
                        type: "warning",
                        closeOnConfirm: true
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                swal("Oops", "Data gagal disimpan!", "error");
            }
        });
    }
    function transaksi() {
        $('[name="karyawan_id"] :selected').removeAttr('selected');
        $('.m-select2').select2({
            width: '100%'
        });

        var jenis = document.getElementById('jenis').value;

        if (jenis == 'umum') {
            $('#transaksi_anggota').hide();
            $('#transaksi_umum').show();
        } else if(jenis == 'anggota koperasi') {
            $('#transaksi_anggota').show();
            $('#transaksi_umum').show();
            $('#saldo_title').show();
            $('#saldo_number').show();
        } else {
            $('#transaksi_anggota').show();
            $('#transaksi_umum').hide();
            $('#saldo_title').hide();
            $('#saldo_number').hide();
        }
    }
    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
    function getSaldo() {
        var selectedKaryawanId = $('#karyawan_select').val();

        $.ajax({
            url: "{{ route('penjualan.getSaldo') }}",
            dataType: "json",
            type: "GET",
            data: {
                karyawan_id: selectedKaryawanId
            },
            success: function(response) {
                if (response.success) {
                    var saldo = response.data.saldo;
                    $("#saldo_number").html(saldo); //format number belum di pakai
                }
            },
            error: function(xhr, textStatus, errorThrown) {
            }
        });
    }
</script>
@stop