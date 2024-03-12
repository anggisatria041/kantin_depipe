@extends('layout.main')
@section('subheader')
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">Local Data</h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="#" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="" class="m-nav__link">
                        <span class="m-nav__link-text">Metronic Datatable</span>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="" class="m-nav__link">
                        <span class="m-nav__link-text">Base</span>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="" class="m-nav__link">
                        <span class="m-nav__link-text">Local Data</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Local Datatable
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
                                <div class="m-form__group m-form__group--inline">
                                    <div class="m-form__label">
                                        <label>Status:</label>
                                    </div>
                                    <div class="m-form__control">
                                        <select class="form-control m-bootstrap-select" id="m_form_status">
                                            <option value="">All</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Request">Request</option>
                                            <option value="Canceled">Canceled</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="d-md-none m--margin-bottom-10"></div>
                            </div>
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
                    <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                        <a href="#" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                            <span>
                                <i class="la la-cart-plus"></i>
                                <span>New Order</span>
                            </span>
                        </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                </div>
            </div>
            <!--end: Search Form -->

            <!--begin: Datatable -->
            <div class="m_datatable" id="local_data"></div>
            <!--end: Datatable -->
        </div>
    </div>
<script>
    window.addEventListener('DOMContentLoaded', (event) => {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    var tableData = $('.m_datatable').mDatatable({
        data: {
            type: 'remote', 
            source: {
                read: {
                    url: "{{ route('data_list') }}", 
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
            field: "tgl_sewa",
            title: "Tanggal Sewa"
        }, {
            field: "tgl_berakhir",
            title: "Tanggal Berakhir"
        }, {
            field: "harga",
            title: "Harga",
            width: 110,
            textAlign: 'center'
        }, {
            field: "status",
            title: "Status",
            textAlign: 'center'
        }, {
            field: "actions",
            width: 110,
            title: "Actions",
            sortable: false,
            overflow: 'visible',
            template: function (row, index, datatable) {
                return '\
                    <div class="dropdown">\
                        <a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown">\
                            <i class="la la-ellipsis-h"></i>\
                        </a>\
                        <div class="dropdown-menu dropdown-menu-right">\
                            <a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>\
                            <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>\
                            <a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>\
                        </div>\
                    </div>\
                    <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="View ">\
                        <i class="la la-edit"></i>\
                    </a>\
                ';
            }
        }]
        });

        $('#m_form_status').on('change', function () {
            tableData.search($(this).val(), 'status');
        });

        $('#m_form_status').selectpicker();
    });
</script>
@stop