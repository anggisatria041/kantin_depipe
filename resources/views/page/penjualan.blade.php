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
                <div class="m-widget1">
                    <div class="m-widget1__item">
                        <div class="row m-row--no-padding align-items-center">
                            <div class="col">
                                <h3 class="m-widget1__title">Barcode</h3>
                            </div>
                            <div class="col m--align-right">
                                <input type="text" name="barang" required class="form-control m-input"/>
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
                                <a href="javascript:void(0)" onclick="" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="checkout">
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
                                <span class="m-widget1__number m--font-brand">0,00</span>
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
                                <input type="number" name="bayar" required class="form-control m-input"/><br>
                                <span class="m-widget1__number m--font-success">0,00</span>
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

<!-- form -->
<div class="modal fade" id="m_modal_6" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header m--bg-brand">
                <h5 class="modal-title m--font-light" id="exampleModalLongTitle">
                    Tambah
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        &times;
                    </span>
                </button>
            </div>
            <form class="m-form m-form--fit m-form--label-align-right" action="" method="POST" id="formAdd" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="m-form__content">
                        <div class="m-alert m-alert--icon alert alert-danger" role="alert" id="m_form_1_msg">
                            <div class="m-alert__icon">
                                <i class="la la-warning"></i>
                            </div>
                            <div class="m-alert__text">
                                Upss .. ! Periksa kembali data yang anda inputkan, pastikan seluruh kolom required terisi.
                            </div>
                            <div class="m-alert__close">
                                <button type="button" class="close" data-close="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="stok_barang_id" value="">
                    <div class="form-group m-form__group row" >
                        <label class="col-form-label col-md-3" style="text-align:left">
                            Nama Barang <font class="m--font-danger">*</font>
                        </label>
                            <div class="col-md-6">
                            <input type="text" name="nama" required class="form-control m-input" placeholder="Nama Barang"/>
                        </div>
                    </div>
                    <div class="form-group m-form__group row" >
                        <label class="col-form-label col-md-3" style="text-align:left">
                            Barcode <font class="m--font-danger">*</font>
                        </label>
                            <div class="col-md-6">
                            <input type="number" name="barcode" required class="form-control m-input" placeholder="Barcode"/>
                        </div>
                    </div>
                    <div class="form-group m-form__group row" >
                        <label class="col-form-label col-md-3" style="text-align:left">
                            Jumlah <font class="m--font-danger">*</font>
                        </label>
                            <div class="col-md-6">
                            <input type="number" name="jumlah" required class="form-control m-input" placeholder="Jumlah"/>
                        </div>
                    </div>
                    <div class="form-group m-form__group row" >
                        <label class="col-form-label col-md-3" style="text-align:left">
                            Satuan <font class="m--font-danger">*</font>
                        </label>
                            <div class="col-md-6">
                            <input type="text" name="satuan" required class="form-control m-input" placeholder="satuan"/>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-form-label col-md-3" style="text-align:left">
                            Harga<font class="m--font-danger">*</font>
                        </label>
                        <div class="col-md-6">
                            <input type="number" name="harga" required class="form-control m-input" placeholder="Harga"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-warning" data-dismiss="modal">
                        Batal
                    </a>
                    <a href="#" onclick="save()" id="btnSaveAjax" class="btn btn-accent">
                        Simpan
                    </a>

                </div>
            </form>
            <!--end::Form-->
        </div>
    </div>
</div>
<!-- end form -->
<script type="text/javascript">
    var method;
    window.addEventListener('DOMContentLoaded', (event) => {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var tableData = $('.m_datatable').mDatatable({
            data: {
                type: 'remote', 
                source: {
                    read: {
                        url: "{{ route('stok_barang.data_list') }}", 
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
                field: "barcode",
                title: "Barcode"
            }, {
                field: "jumlah",
                title: "Jumlah"
            }, {
                field: "satuan",
                title: "Satuan",
                width: 110,
                textAlign: 'center'
            }, {
                field: "harga",
                title: "Harga",
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
</script>
@stop