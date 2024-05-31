
@extends('layout.main')
@section('subheader')
<!-- BEGIN: Subheader -->
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">
                <div class="text-capitalize">
                    Laporan Penjualan
                </div>
            </h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="{{route('dashboard.index')}}" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">
                    -
                </li>
                <li class="m-nav__item">
                    <span class="m-nav__link-text">
                        Report
                    </span>
                </li>
                <li class="m-nav__separator">
                    -
                </li>
                <li class="m-nav__item">
                    <a href="" class="m-nav__link">
                        <span class="m-nav__link-text">
                            Laporan Penjualan
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- END: Subheader -->
@endsection
@section('content')
<!--begin::Portlet-->
<div class="m-portlet">

    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    Laporan Penjualan
                </h3>
            </div>
        </div>
    </div>

    <form action="" id="formLap" class="m-form m-form--fit m-form--label-align-right">
        <!--begin::Form-->
        <div class="m-portlet__body">
            <div class="m-form__section m-form__section--first">
                <div class="form-group m-form__group row">
                    <label class="col-form-label col-md-3">
                        Transaksi<font class="m--font-danger">*</font>
                    </label>
                    <div class="col-md-4">
                        <select name="pelanggan" class="form-control m-input">
                            <option value="">All</option>
                            <option value="umum">Umum</option>
                            <option value="hutang">Hutang</option>
                            <option value="anggota koperasi">Anggota Koperasi</option>
                        </select>
                    </div>
                </div>

                <div class="form-group m-form__group row">
                    <label class="col-form-label col-md-3">
                        Tanggal Mulai<font class="m--font-danger">*</font>
                    </label>
                    <div class="col-md-4">
                        <input type="date" name="tgl_mulai" required class="form-control m-input"  />
                            <div class="form-control-feedback ">
                            <font class="m--font-info">Tanggal Penjualan</font>
                        </div>
                    </div>
                </div>

                <div class="form-group m-form__group row">
                    <label class="col-form-label col-md-3">
                        Tanggal Sampai<font class="m--font-danger">*</font>
                    </label>
                    <div class="col-md-4">
                        <input type="date" name="tgl_sampai" required class="form-control m-input"  />
                        <div class="form-control-feedback ">
                            <font class="m--font-info">Tanggal Penjualan</font>
                        </div>
                    </div>
                </div>

                <div class="m-form__group form-group row">
                    <div class="col-lg-6 col-md-9 col-sm-12">
                        <label class="col-form-label col-lg-4 col-sm-4"></label>
                        <button type="button" onclick="getlaporan()" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air">
                            <span>
                                <i class="fa fa-search"></i>
                                <span>Search</span>
                            </span>
                        </button>
                        &nbsp;
                        <button type="button" onclick="exportExcel()" class="btn btn-success m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air">
                            <span>
                                <i class="la la-file-excel-o"></i>
                                <span>Excel</span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div id="laporan">

        </div>
    </form>
</div>
<!--end::Portlet-->
<script type="text/javascript">
    
    function getlaporan() {

        const formData = $('#formLap').serialize();
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        const formDataWithToken = formData + '&_token=' + encodeURIComponent(csrfToken);
       
        $.ajax({
            url: "{{ route('lp_penjualan.getlaporan') }}",
            type: "POST",
            data: formDataWithToken,
            dataType: "json",
            success: function(data) {
                if (data.status) {
                    $('#laporan').html(data.laporan);
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
    function exportExcel() {
        const formData = $('#formLap').serialize();
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        const formDataWithToken = formData + '&_token=' + encodeURIComponent(csrfToken);

        $.ajax({
            url: "{{ route('lp_penjualan.exportlaporan') }}",
            type: "POST",
            data: formDataWithToken,
            xhrFields: {
                responseType: 'blob'
            },
            success: function(data, status, xhr) {
                const filename = xhr.getResponseHeader('Content-Disposition').split('filename=')[1].replace(/"/g, '');
                const link = document.createElement('a');
                link.href = window.URL.createObjectURL(data);
                link.download = filename;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                swal("Oops", "Data gagal disimpan!", "error");
            }
        });
    }
</script>
@stop
