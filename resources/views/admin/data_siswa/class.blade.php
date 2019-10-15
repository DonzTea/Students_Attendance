@extends('layouts.admin-master')

@section('title')
Data Siswa {{$class->name}}
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
        <h1>Data Siswa</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.students.index') }}">Data Siswa</a></div>
            <div class="breadcrumb-item">{{$class->name}}</div>
        </div>
    </div>

    <div class="section-body">

        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row w-100">
                            <div class="col-2">
                                <h4>{{$class->name}}</h4>
                            </div>
                            <div class="col-10 text-right pr-0">
                                Wali Kelas :
                                @if (App\Teacher::where('homeroom_teacher_of', $class->id)->get()->count() > 0)
                                <a
                                    href="{{ route('admin.teachers.show', 
                                                    App\Teacher::where('homeroom_teacher_of', $class->id)->first()->id) }}">
                                    {{App\Teacher::where('homeroom_teacher_of', $class->id)->first()->name}}
                                </a>
                                @else
                                Belum ada
                                @endif
                            </div>
                        </div>
                        @if ($class->students()->count() == 0)
                        <div class="card-header-action">
                            <a href="{{ route('admin.students.create') }}" class="btn btn-primary">
                                <i class="fas fa-user-plus"></i> Tambah Siswa
                            </a>
                        </div>
                        @endif
                    </div>
                    <div class="card-body">
                        @if ($class->students()->count() > 0)
                        <div class="table-responsive">
                            <table id="datatables" class="table table-striped mb-0 display w-100">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th class="text-center">NIS</th>
                                        <th class="text-center">NISN</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Orang Tua</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        @else
                        <div>
                            <h4 class="text-center">Belum ada siswa di {{$class->name}}</h4>
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
                url: '{{route("admin.students.classData", ["id" => $class->id])}}',
                type: 'GET',
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'nis', name: 'students.nis'},
                { data: 'nisn', name: 'students.nisn'},
                { data: 'name', name: 'students.name'},
                { data: 'student_parent.name', name: 'student_parent.name', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            order: [[1, 'asc']],
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