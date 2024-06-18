@extends('layout.main')
@section('subheader')
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">Penjualan</h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="#" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="" class="m-nav__link">
                        <span class="m-nav__link-text">Penjualan</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="m-portlet m-portlet--head-solid-bg m-portlet--bordered m-portlet--brand">
    <div class="m-portlet__head ">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    Manage Data Penjualan<p id="hax"></p>
                </h3>
            </div>
        </div>
    </div>
    <div class="m-portlet__body">
        <!--begin: Search Form -->
        <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
            <div class="row align-items-center">
                <div class="col-xl-8 order-2 order-xl-1">
                    <div class="form-group m-form__group row align-items-center">
                        <div class="col-md-4">
                            <div class="m-input-icon m-input-icon--left">
                                <input type="text" class="form-control m-input" placeholder="Search..." id="generalSearch">
                                <span class="m-input-icon__icon m-input-icon__icon--left">
                                    <span>
                                        <i class="la la-search"></i>
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end: Search Form -->

        <!--begin: Datatable -->
        <ul class="nav nav-pills nav-fill" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" onclick="renew('#m_datatable')" href="#m_tabs_5_1"><b>Umum</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" onclick="renew('#m_datatable2')" href="#m_tabs_5_2"><b>Hutang</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" onclick="renew('#m_datatable3')" href="#m_tabs_5_3"><b>Anggota Koperasi</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" onclick="renew('#m_datatable4')" href="#m_tabs_5_4"><b>Pengambilan Barang</b></a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="m_tabs_5_1" role="tabpanel">
                <div class="m_datatable" id="m_datatable"></div>
            </div>
            <div class="tab-pane" id="m_tabs_5_2" role="tabpanel">
                <div class="m_datatable2" id="m_datatable2"></div>
            </div>
            <div class="tab-pane" id="m_tabs_5_3" role="tabpanel">
                <div class="m_datatable3" id="m_datatable3"></div>
            </div>
             <div class="tab-pane" id="m_tabs_5_4" role="tabpanel">
                <div class="m_datatable4" id="m_datatable4"></div>
            </div>
        </div>
        <!--end: Datatable -->
    </div>
</div>

<script type="text/javascript">
    var method;
    window.addEventListener('DOMContentLoaded', (event) => {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var tableData = $('.m_datatable').mDatatable({
            data: {
                type: 'remote', 
                source: {
                    read: {
                        url: "{{ route('penjualan.detail_list') }}", 
                        method: 'POST', 
                        headers: {
                            'X-CSRF-TOKEN': csrfToken 
                        },
                        dataType: 'json',
                        params: {
                            pelanggan: 'umum' 
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
                field: "no_transaksi",
                title: "No Transaksi"
            }, {
                field: "nama_barang",
                title: "Nama Barang"
            }, {
                field: "jumlah",
                title: "Jumlah"
            }, {
                field: "total_bayar",
                title: "Total Bayar"
            }, {
                field: "tanggal",
                title: "Tanggal"
            }]
        });
        var tableData = $('.m_datatable2').mDatatable({
            data: {
                type: 'remote', 
                source: {
                    read: {
                        url: "{{ route('penjualan.detail_list') }}", 
                        method: 'POST', 
                        headers: {
                            'X-CSRF-TOKEN': csrfToken 
                        },
                        dataType: 'json',
                        params: {
                            pelanggan: 'hutang' 
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
                field: "no_transaksi",
                title: "No Transaksi"
            }, {
                field: "nama_barang",
                title: "Nama Barang"
            }, {
                field: "jumlah",
                title: "Jumlah"
            }, {
                field: "total_bayar",
                title: "Total Bayar"
            }, {
                field: "tanggal",
                title: "Tanggal"
            }]
        });
        var tableData = $('.m_datatable3').mDatatable({
            data: {
                type: 'remote', 
                source: {
                    read: {
                        url: "{{ route('penjualan.detail_list') }}", 
                        method: 'POST', 
                        headers: {
                            'X-CSRF-TOKEN': csrfToken 
                        },
                        dataType: 'json',
                        params: {
                            pelanggan: 'anggota koperasi' 
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
                field: "no_transaksi",
                title: "No Transaksi"
            }, {
                field: "nama_barang",
                title: "Nama Barang"
            }, {
                field: "jumlah",
                title: "Jumlah"
            }, {
                field: "total_bayar",
                title: "Total Bayar"
            }, {
                field: "tanggal",
                title: "Tanggal"
            }]
        });

        var tableData = $('.m_datatable4').mDatatable({
            data: {
                type: 'remote', 
                source: {
                    read: {
                        url: "{{ route('penjualan.detail_list') }}", 
                        method: 'POST', 
                        headers: {
                            'X-CSRF-TOKEN': csrfToken 
                        },
                        dataType: 'json',
                        params: {
                            pelanggan: 'pengambilan barang' 
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
                field: "no_transaksi",
                title: "No Transaksi"
            }, {
                field: "pic",
                title: "PIC"
            }, {
                field: "nama_barang",
                title: "Nama Barang"
            }, {
                field: "jumlah",
                title: "Jumlah"
            }, {
                field: "keterangan",
                title: "Keterangan"
            }, {
                field: "tanggal",
                title: "Tanggal"
            }]
        });
        var exportButton = $('<a>').text('Excel').attr('href', '{{ route('penjualan.exportlaporan') }}').addClass('btn btn-success mb-2');
        $('.m_datatable4').before(exportButton);
        $('#m_form_status').on('change', function () {
            tableData.search($(this).val(), 'status');
        });

        $('#m_form_status').selectpicker();
    });
    function renew(selector) {
        $(selector).mDatatable().reload();
    }
</script>
@stop