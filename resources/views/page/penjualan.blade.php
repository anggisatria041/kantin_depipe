@extends('layout.main')
@section('content')
<div class="m-portlet">
    <div class="m-portlet__body  m-portlet__body--no-padding">
        <div class="row m-row--no-padding m-row--col-separator-xl">
            <div class="col-xl-4">
                <div class="m-widget1">
                    <div class="m-widget1__item">
                        <div class="row m-row--no-padding align-items-center">
                            <div class="col">
                                <h3 class="m-widget1__title">No Transaksi</h3>
                            </div>
                            <div class="col m--align-right">
                                <input type="text" name="no_transaksi" required class="form-control m-input" value="0021/KSR/23" disabled/>
                            </div>
                        </div>
                    </div>
                    <div class="m-widget1__item">
                        <div class="row m-row--no-padding align-items-center">
                            <div class="col">
                                <h3 class="m-widget1__title">Tanggal</h3>
                            </div>
                            <div class="col m--align-right">
                                <input type="text" name="tanggal" required class="form-control m-input" value="<?= date('Y-m-d'); ?>" disabled/>
                            </div>
                        </div>
                    </div>
                    <div class="m-widget1__item">
                        <div class="row m-row--no-padding align-items-center">
                            <div class="col">
                                <h3 class="m-widget1__title">Pelanggan</h3>
                            </div>
                            <div class="col m--align-right">
                                <select name="level" class="form-control m-input">
                                    <option value="Umum">Umum</option>
                                    <option value="anggota">Anggota Koperasi</option>
                                    <option value="hutang">Hutang</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <form class="m-form m-form--fit m-form--label-align-right" action="" method="POST" id="formAdd" enctype="multipart/form-data">
                <input type="hidden" name="penjualan_id"  value="">
                <div class="m-widget1">
                    <div class="m-widget1__item">
                        <div class="row m-row--no-padding align-items-center">
                            <div class="col">
                                <h3 class="m-widget1__title">Barcode</h3>
                            </div>
                            <div class="col m--align-right">
                                <select class="form-control" name="stok_barang_id" id="kode">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="m-widget1__item">
                        <div class="row m-row--no-padding align-items-center">
                            <div class="col">
                                <h3 class="m-widget1__title">Qty</h3>
                            </div>
                            <div class="col m--align-right">
                                <input type="number" name="jumlah" required class="form-control m-input"/>
                            </div>
                        </div>
                    </div>
                    <div class="m-widget1__item">
                        <div class="row m-row--no-padding align-items-center">
                            <div class="col m--align-right">
                                <a href="#" onclick="save()" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="checkout">
                                    <i class="fa fa-cart-arrow-down custom-icon" style="color: green;"></i>
                                </a>
                            </div><br>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="m-widget1">
                    <div class="m-widget1__item">
                        <div class="row m-row--no-padding align-items-center">
                            <div class="col">
                                <h3 class="m-widget1__title">Total Bayar</h3>
                            </div>
                            <div class="col m--align-right">
                                <span class="m-widget1__number m--font-brand" id="total_bayar">{{$total_bayar}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="m-widget1__item">
                        <div class="row m-row--no-padding align-items-center">
                            <div class="col">
                                <h3 class="m-widget1__title">Cash</h3><br>
                                <h3 class="m-widget1__title">Kembali</h3>
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
                                <button type="button" class="btn btn-primary btn-sm">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
    window.addEventListener('DOMContentLoaded', (event) => {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var tableData = $('.m_datatable').mDatatable({
            data: {
                type: 'remote', 
                source: {
                    read: {
                        url: "{{ route('penjualan.data_list') }}", 
                        method: 'POST', 
                        headers: {
                            'X-CSRF-TOKEN': csrfToken 
                        },
                        dataType: 'json' 
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
                field: "jumlah",
                title: "Jumlah"
            }, {
                field: "harga_jual",
                title: "Harga",
                width: 110,
                textAlign: 'center'
            }, {
                field: "total_bayar",
                title: "Total",
                textAlign: 'center'
            }, {
                field: "actions",
                width: 110,
                title: "Actions",
                sortable: false,
                overflow: 'visible'
            }]
            });

            $('#m_form_status').on('change', function () {
                tableData.search($(this).val(), 'status');
            });

            $('#m_form_status').selectpicker();
    });
    function resetForm() {
        $('#m_form_1_msg').hide();
        $('#formAdd')[0].reset();
        $('#kode').val('').trigger('change');
        $('.m-select2').select2({
            width: '100%'
        });
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
        var total = parseFloat(document.getElementById('total_bayar').innerText.replace(',', '.'));
        var bayar = parseFloat(document.getElementById('bayar').value);
        var kembalian = bayar - total;
        document.getElementById('kembalian').innerHTML = kembalian.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
    }

</script>
@stop