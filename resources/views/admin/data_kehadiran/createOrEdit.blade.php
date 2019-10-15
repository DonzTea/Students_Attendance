@extends('layouts.admin-master')

@section('title')
Isi Kehadiran
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
        @if ($class->students()->count() &&
        $class->presences()->where('date', $date)->first() !== null)
        <h1>Isi Data Kehadiran</h1>
        @else
        <h1>Data Kehadiran</h1>
        @endif
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.presences.index') }}">Data Kehadiran</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.presences.show', [
                'id' => $class->id,
                'month' => date('m'),
            ]) }}">{{$class->name}}</a>
            </div>
            <div class="breadcrumb-item">{{$date}}</div>
        </div>
    </div>

    <div class="section-body">
        @if ($class->students()->count() > 0)
        <div class="card">
            <div class="card-header">
                <h4>{{$class->name}}, Tanggal {{$date}}</h4>
                @if ($class->students()->count() &&
                $class->presences()->where('date', $date)->first() !== null)
                <div class="card-header-action">
                    <form action="{{route('admin.presences.destroy', [
                                'id' => $class->id,
                                'date' => $date,
                            ])}}" method="post">
                        @method('DELETE')
                        @csrf
                        <button class="btn btn-danger" type="submit">
                            <i class="far fa-calendar-times"></i> Hapus Kehadiran
                        </button>
                    </form>
                </div>
                @endif
            </div>

            @if ($class->students()->count() &&
            $class->presences()->where('date', $date)->first() !== null)
            <form action="{{ route('admin.presences.update', [
                            'id' => $class->id, 
                            'date' => $date,
                        ]) }}" method="post">
                @csrf
                @method('PUT')
                @else
                <form action="{{ route('admin.presences.store', [
                                'id' => $class->id,
                                'date' => $date,
                            ]) }}" method="post">
                    @csrf
                    @endif
                    <div class="card-body">
                        <div class="table-responsive mb-0 display w-100">
                            <table id="datatables" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">NO</th>
                                        <th class="text-center">NISN</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Masuk</th>
                                        <th class="text-center">Sakit</th>
                                        <th class="text-center">Izin</th>
                                        <th class="text-center">Alfa</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    @if ($class->students()->count())
                    <div class="text-center mb-4">
                        <button class="btn btn-primary w-25" type="submit">
                            @if ($class->presences()->where('date', $date)->first() == null)
                            Selesai
                            @else
                            Perbarui
                            @endif
                        </button>
                        <button class="btn btn-secondary w-25" type="reset">Batal</button>
                    </div>
                    @endif
                </form>
        </div>
        @else
        <div class="card">
            <div class="card-header">
                <h4>{{$class->name}}, Tanggal {{$date}}</h4>
            </div>
            <div class="card-body">
                <h4 class="text-center">Belum ada siswa di {{$class->name}}</h4>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection

@section('scripts')
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
                searching: false,
                paging: false,
                info: false,
                ajax: {
                    url: '{{route("admin.students.class.presence", ["id" => $class->id, "date" => $date])}}',
                    type: 'GET',
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'nisn', name: 'students.nisn'},
                    { data: 'name', name: 'students.name'},
                    { data: 'masuk', name: 'masuk', orderable: false, searchable: false },
                    { data: 'sakit', name: 'sakit', orderable: false, searchable: false },
                    { data: 'izin', name: 'izin', orderable: false, searchable: false },
                    { data: 'alfa', name: 'alfa', orderable: false, searchable: false },
                ],
                order: [[2, 'asc']],
                columnDefs: [
                    {
                        targets: '_all',
                        defaultContent: '<div class="text-danger">Data belum diisi</div>',
                    },
                    {
                        targets: [0, -1, -2, -3, -4],
                        className: 'text-center',
                    },
                    { 
                        responsivePriority: 1, 
                        targets: [-1, -2, -3, -4], 
                    },
                    { 
                        responsivePriority: 2, 
                        targets: 1, 
                    },
                    { 
                        responsivePriority: 3, 
                        targets: 2, 
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