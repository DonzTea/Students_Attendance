@extends('layouts.admin-master')

@section('title')
Data Guru {{$class->name}} Tahun Pelajaran {{$year->name}} - {{$year->name + 1}}
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
        <h1>Data Guru Tahun Pelajaran {{$year->name}} - {{$year->name + 1}}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">
                <a href="{{ route('admin.historyTeachers.index', $year->id) }}">
                    Data Guru {{$year->name}} - {{$year->name + 1}}
                </a>
            </div>
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
                                @if (App\HistoryTeacher::where('homeroom_teacher_of', $class->id)->get()->count() > 0)
                                <a href="{{ route('admin.historyTeachers.show', [
                            'teacher_id' => App\HistoryTeacher::where('homeroom_teacher_of', $class->id)->first()->id,
                            'year_id' => $year->id,
                            ]) }}">
                                    {{App\HistoryTeacher::where('homeroom_teacher_of', $class->id)->first()->name}}
                                </a>
                                @else
                                <span class="text-danger">
                                    Tidak Ada
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($class->historyTeachers()->count() > 0)
                        <div class="table-responsive">
                            <table id="datatables" class="table table-striped mb-0 display w-100">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">NIP</th>
                                        <th class="text-center">Karpeg</th>
                                        <th class="d-none">ID Jabatan</th>
                                        <th class="text-center">Jabatan</th>
                                        <th class="text-center">Golongan</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        @else
                        <div>
                            <h4 class="text-center">Tidak ada Guru di {{$class->name}} pada tahun pelajaran
                                {{$year->name}} - {{$year->name + 1}}
                            </h4>
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
                        url: '{{route("admin.historyTeachers.schoolYearClassData", [$year->id, $class->id])}}',
                        type: 'GET',
                    },
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                        { data: 'name', name: 'history_teachers.name'},
                        { data: 'nip', name: 'history_teachers.nip' },
                        { data: 'karpeg', name: 'history_teachers.karpeg' },
                        { data: 'position_id', name: 'history_teachers.position_id', visible: false, searchable: false },
                        { data: 'position.name', name: 'position.name'},
                        { data: 'type', name: 'history_teachers.type' },
                    ],
                    order: [[4, 'asc']],
                    columnDefs: [
                        {
                            targets: '_all',
                            defaultContent: '<div class="text-danger">Tidak ada data</div>',
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
@endsection