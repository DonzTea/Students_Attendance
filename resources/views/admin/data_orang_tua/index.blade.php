@extends('layouts.admin-master')

@section('title')
Data Orang Tua
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.10/css/bootstrap-select.min.css">
<link rel="stylesheet" type="text/css"
    href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-colvis-1.5.6/b-flash-1.5.6/b-html5-1.5.6/b-print-1.5.6/r-2.2.2/datatables.min.css" />
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Data Orang Tua</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Data Orang Tua</div>
        </div>
    </div>

    <div class="section-body">

        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Orang Tua</h4>
                        <div class="card-header-action">
                            <a href="{{ route('admin.parents.create') }}" class="btn btn-primary">
                                <i class="fas fa-user-plus"></i> Tambah Orang Tua
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($parents->count() > 0)
                        <div class="table-responsive">
                            <table id="datatables" class="table table-striped mb-0 display w-100">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th class="text-center">Nama</th>
                                        <th class="d-none">ID Agama</th>
                                        <th class="text-center">Agama</th>
                                        <th class="d-none">ID Pendidikan Tertinggi</th>
                                        <th class="text-center">Pendidikan Tertinggi</th>
                                        <th class="text-center">Pekerjaan</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        @else
                        <div>
                            <h4 class="text-center">Belum ada orang tua</h4>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
{{-- Libraries for specific page --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript"
    src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-colvis-1.5.6/b-flash-1.5.6/b-html5-1.5.6/b-print-1.5.6/r-2.2.2/datatables.min.js">
</script>

{{-- Success Alert --}}
@if ($message = Session::get('success'))
<script>
    swal("Sukses!", "{{ $message }}", "success");
</script>
@endif

{{-- Datatables --}}
<script>
    $(document).ready( function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#datatables').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{route("admin.parents.all")}}',
                type: 'GET',
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'student_parents.name'},
                { data: 'religion_id', name: 'student_parents.religion_id', visible: false, searchable: false },
                { data: 'religion.name', name: 'religion.name' },
                { data: 'education_id', name: 'student_parents.education_id', visible: false, searchable: false },
                { data: 'education.name', name: 'education.name' },
                { data: 'profession', name: 'student_parents.profession'},
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            order: [[4, 'asc']],
            columnDefs: [
                {
                    targets: '_all',
                    defaultContent: '<div class="text-danger">Data belum diisi</div>',
                },
                {
                    targets: [0, -1,],
                    className: 'text-center',
                },
            ],
            language: {
                sEmptyTable: "Tidak ada data yang tersedia pada tabel ini",
                sProcessing: "Sedang memproses...",
                sLengthMenu: "Tampilkan _MENU_ entri",
                sZeroRecords: "Tidak ditemukan data yang sesuai",
                sInfo: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                sInfoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
                sInfoFiltered: "(disaring dari _MAX_ entri keseluruhan)",
                sInfoPostFix: "",
                sSearch: "Cari:",
                sUrl: "",
                oPaginate: {
                sFirst: "Pertama",
                sPrevious: "Sebelumnya",
                sNext: "Selanjutnya",
                sLast: "Terakhir"
                }
            },
        });

        $('td > Data belum diisi').addClass('text-danger');
    });
</script>

{{-- Action button delete confirmation --}}
<script>
    $(document).on("click", ".button_delete", function(e) {

        e.preventDefault();

        var id = $(this).data("id");
        var parent = $('form#' + id);
        
        swal({
            title: "Apakah anda yakin?",
            text: "Setelah dihapus data terpilih akan hilang.",
            icon: "warning",
            buttons: ["Tidak", "Ya"],
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                parent.submit();
            } else {
                swal("Data batal dihapus.", {
                    icon: "info",
                });
            }
        });
    });
</script>
@endsection