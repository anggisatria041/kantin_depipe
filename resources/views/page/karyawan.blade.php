@extends('layout.main')
@section('subheader')
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">Karyawan</h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="#" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="" class="m-nav__link">
                        <span class="m-nav__link-text">Karyawan</span>
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
                    Manage Data Karyawan<p id="hax"></p>
                </h3>
            </div>
        </div>
        <div class="m-portlet__head-tools">
            <button type="button" class="btn btn-info btn-md" onclick="add_ajax()">
                <i class="la la-plus"></i> Tambah
            </button>
        </div>
    </div>
    <div class="m-portlet__body">
        <!--begin: Search Form -->
        <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
            <div class="row align-items-center">
                <div class="col-xl-8 order-2 order-xl-1">
                    <div class="form-group m-form__group row align-items-center">
                        <!-- <div class="col-md-4">
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
                        </div> -->
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
            <li class="nav-item col-6">
                <a class="nav-link active" data-toggle="tab" onclick="renew('#m_datatable')" href="#m_tabs_5_1"><b>Anggota Koperasi</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" onclick="renew('#m_datatable2')" href="#m_tabs_5_2"><b>Umum</b></a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="m_tabs_5_1" role="tabpanel">
                <div class="m_datatable" id="m_datatable"></div>
            </div>
            <div class="tab-pane" id="m_tabs_5_2" role="tabpanel">
                <div class="m_datatable2" id="m_datatable2"></div>
            </div>
        </div>
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
                    <input type="hidden" name="karyawan_id" value="">
                    <div class="form-group m-form__group row" >
                        <label class="col-form-label col-md-3" style="text-align:left">
                            Nama <font class="m--font-danger">*</font>
                        </label>
                            <div class="col-md-6">
                            <input type="text" name="nama" required class="form-control m-input" placeholder="Nama"/>
                        </div>
                    </div>
                    <div class="form-group m-form__group row" >
                        <label class="col-form-label col-md-3" style="text-align:left">
                            Alamat <font class="m--font-danger">*</font>
                        </label>
                            <div class="col-md-6">
                            <input type="text" name="alamat" required class="form-control m-input" placeholder="Alamat"/>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-form-label col-md-3" style="text-align:left">
                            No Hp <font class="m--font-danger">*</font>
                        </label>
                        <div class="col-md-6">
                            <input type="number" name="no_hp" required class="form-control m-input" placeholder="No Hp"/>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-form-label col-md-3" style="text-align:left">
                            Anggota Koperasi <font class="m--font-danger">*</font>
                        </label>
                        <div class="m-radio-list">
                            <label class="m-radio">
                                <input type="radio" name="anggota_koperasi" value="Ya" checked="checked"> Ya
                                <span></span>
                            </label>
                            <label class="m-radio">
                                <input type="radio" name="anggota_koperasi" value="Tidak"> Tidak 
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group m-form__group row spkadd">
                        <label class="col-form-label col-md-3" style="text-align:left">
                            Divisi <font class="m--font-danger">*</font>
                        </label>
                        <div class="col-md-6">
                            <select name="divisi" class="form-control m-input m-select2">
                                <option value="">Pilih Divisi</option>
                                <option value="Staff">Staff</option>
                                <option value="Dosen">Dosen</option>
                                <option value="House Keeping">House Keeping</option>
                            </select>
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
                        url: "{{ route('karyawan.data_list') }}", 
                        method: 'POST', 
                        headers: {
                            'X-CSRF-TOKEN': csrfToken 
                        },
                        dataType: 'json',
                        params: {
                            anggota_koperasi: 'Ya' 
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
                title: "Nama"
            }, {
                field: "alamat",
                title: "Alamat"
            }, {
                field: "no_hp",
                title: "No Hp",
                width: 110,
                textAlign: 'center'
            }, {
                field: "divisi",
                title: "Divisi",
                textAlign: 'center'
            }, {
                field: "actions",
                width: 110,
                title: "Actions",
                sortable: false,
                overflow: 'visible'
            }]
        });
        var tableData = $('.m_datatable2').mDatatable({
            data: {
                type: 'remote', 
                source: {
                    read: {
                        url: "{{ route('karyawan.data_list') }}", 
                        method: 'POST', 
                        headers: {
                            'X-CSRF-TOKEN': csrfToken 
                        },
                        dataType: 'json',
                        params: {
                            anggota_koperasi: 'Tidak' 
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
                title: "Nama"
            }, {
                field: "alamat",
                title: "Alamat"
            }, {
                field: "no_hp",
                title: "No Hp",
                width: 110,
                textAlign: 'center'
            }, {
                field: "divisi",
                title: "Divisi",
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
    function renew(selector) {
        $(selector).mDatatable().reload();
    }
    function resetForm() {
        $('#m_form_1_msg').hide();
        $('#formAdd')[0].reset();
        $('[name="status"] :selected').removeAttr('selected');
        $('.m-select2').select2({
            width: '100%'
        });
    }

    function add_ajax() {
        method = 'add';
        resetForm();
        $('#exampleModalLongTitle').html("Tambah Karyawan");
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();
        $('#m_form_1_msg').hide();
        $('#m_modal_6').modal('show');
        $('#btnSaveAjax').show();
    }
    function save() {
        let url;

        if (method === 'add') {
            url = "{{ route('karyawan.store') }}";
        } else {
            url = "{{ route('karyawan.update') }}";
        }

        const formData = $('#formAdd').serialize();
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        const formDataWithToken = formData + '&_token=' + encodeURIComponent(csrfToken);
        if ($('[name="nama"]').val() == "" || $('[name="alamat"]').val() == "" || $('[name="no_hp"]').val() == "" || $('[name="divisi"]').val() == "") {
            $('#m_form_1_msg').show();
            mApp.unblock(".modal-content");
        } else {
            $.ajax({
                url: url,
                type: "POST",
                data: formDataWithToken,
                dataType: "json",
                success: function(data) {
                    if (data.status) {
                        $('#m_modal_6').modal('hide');
                        swal("Berhasil..", "Data Anda berhasil disimpan", "success");
                        $('.m_datatable').mDatatable().reload();
                        $('.m_datatable2').mDatatable().reload();
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
    }
    function edit(id) {
        method = 'edit';
        resetForm(); 

        $('#exampleModalLongTitle').html("Edit Karyawan"); 

        $.ajax({
            url: "{{ url('karyawan/edit') }}/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                if (data.data) {
                    $('#formAdd')[0].reset();
                    $('[name="karyawan_id"]').val(data.data.karyawan_id);
                    $('[name="nama"]').val(data.data.nama);
                    $('[name="alamat"]').val(data.data.alamat);
                    $('[name="no_hp"]').val(data.data.no_hp);
                    $('[name="divisi"]').val(data.data.divisi);
                    $('[name="anggota_koperasi"]').each(function() {
                        if ($(this).val() == data.data.is_anggota_koperasi) {
                            $(this).prop('checked', true);
                        }
                    });
                    $('.m-select2').select2({width : '100%'});
                    $('#m_modal_6').modal('show'); 
                } else {
                    swal("Oops", "Gagal mengambil data!", "error");
                }
                mApp.unblockPage();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                mApp.unblockPage();
                alert('Error get data from ajax');
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
                    url: "{{ url('karyawan') }}/" + id, 
                    type: "DELETE", 
                    data: {
                        _token: '{{ csrf_token() }}' 
                    },
                    dataType: "JSON",
                    success: function(data) {
                        if (data.status == true) {
                            swal("Berhasil..", "Data Anda berhasil dihapus", "success");
                            $('.m_datatable').mDatatable().reload();
                            $('.m_datatable2').mDatatable().reload();
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
</script>
@stop