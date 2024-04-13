@extends('layout.main')
@section('subheader')
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">Barcode</h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="#" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="" class="m-nav__link">
                        <span class="m-nav__link-text">Barcode</span>
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
                    Manage Barcode<p id="hax"></p>
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
        <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Meja</th>
                    <th>Barcode</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                @endphp
                @foreach($data as $row)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $row->no_meja }}</td>
                    <td>{!! QrCode::size(50)->generate($row->barcode) !!}</td>
                    <td><div class="dropdown">
                            <a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown">
                                <i class="la la-gear"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="javascript:void(0)" onclick="edit({{ $row->barcode_id }})"><i class="la la-edit"></i> Edit</a>
                                <a class="dropdown-item" href="javascript:void(0)" onclick="hapus({{ $row->barcode_id }})"><i class="la la-trash-o"></i> Hapus</a>
                                <a class="dropdown-item" href="#"><i class="la la-download"></i> Download</a>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            <tbody>
        </table>
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
                    <input type="hidden" name="barcode_id" value="">
                    <div class="form-group m-form__group row" >
                        <label class="col-form-label col-md-3" style="text-align:left">
                            No Meja <font class="m--font-danger">*</font>
                        </label>
                            <div class="col-md-6">
                            <input type="text" name="no_meja" required class="form-control m-input" placeholder="No Meja"/>
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
    function resetForm() {
        $('#m_form_1_msg').hide();
        $('#formAdd')[0].reset();
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
            url = "{{ route('barcode.store') }}";
        } else {
            url = "{{ route('barcode.update') }}";
        }

        const formData = $('#formAdd').serialize();
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        const formDataWithToken = formData + '&_token=' + encodeURIComponent(csrfToken);
        if ($('[name="no_meja"]').val() == "") {
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
                        swal("Berhasil..", "Data Anda berhasil disimpan", "success").then(function() {
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
    }
    function edit(id) {
        method = 'edit';
        resetForm(); 

        $('#exampleModalLongTitle').html("Edit Karyawan"); 

        $.ajax({
            url: "{{ url('barcode/edit') }}/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                if (data.data) {
                    $('#formAdd')[0].reset();
                    $('[name="barcode_id"]').val(data.data.barcode_id);
                    $('[name="no_meja"]').val(data.data.no_meja);
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
                    url: "{{ url('barcode') }}/" + id, 
                    type: "DELETE", 
                    data: {
                        _token: '{{ csrf_token() }}' 
                    },
                    dataType: "JSON",
                    success: function(data) {
                        if (data.status == true) {
                            swal("Berhasil..", "Data Anda berhasil dihapus", "success");
                            swal("Berhasil..", "Data Anda berhasil disimpan", "success").then(function() {
                                location.reload();
                            });
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