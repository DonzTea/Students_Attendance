@extends('layouts.admin-master')

@section('title')
Data Kehadiran
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{$class->name}}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.presences.index') }}">Data Kehadiran</a></div>
            <div class="breadcrumb-item">{{$class->name}}</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>Data Kehadiran</h4>
                <div class="card-header-action">
                    <div class="btn-group dropleft">
                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-calendar"></i> Pilih Bulan
                        </button>
                        <div class="dropdown-menu dropleft" x-placement="left-start"
                            style="position: absolute; transform: translate3d(-2px, 0px, 0px); top: 0px; left: 0px; will-change: transform;">
                            @foreach ($monthList as $index => $monthName)
                            @if ($index <= date('m')) <a class="dropdown-item" href="{{ route('admin.presences.show', [
                                                'id' => $class->id,
                                                'month' => $index,
                                            ]) }}">{{$monthName}}</a>
                                @else
                                <a class="dropdown-item disabled" href="#">{{$monthName}}</a>
                                @endif
                                @endforeach
                        </div>
                    </div>
                    @if ($isDownloadable)
                    <a href="{{route('admin.presences.export', [
                            'id' => $class->id,
                            'date' => date('d-'.$month.'-Y'),
                        ])}}" class="btn btn-success">
                        <i class="fas fa-download"></i> Excel
                    </a>
                    @endif
                    <a href="{{route('admin.presences.createOrEdit', [
                        'id' => $class->id,
                        'date' => date('d-m-Y'),
                    ])}}" class="btn btn-primary">
                        <i class="far fa-calendar-plus"></i>
                        Hari ini
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if ($class->students()->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-light">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="text-center align-middle" rowspan="3">NO</th>
                                <th scope="col" class="text-center align-middle" rowspan="3">Nama</th>
                                <th scope="col" class="text-center align-middle"
                                    colspan="{{cal_days_in_month(CAL_GREGORIAN,date($month),date('Y'))}}">
                                    Bulan {{$currentMonth.' '.date('Y')}}
                                </th>
                            </tr>
                            <tr>
                                <th scope="col" class="text-center align-middle"
                                    colspan="{{cal_days_in_month(CAL_GREGORIAN,date($month),date('Y'))}}">Tanggal</th>
                            </tr>
                            <tr>
                                @for ($i = 0; $i < cal_days_in_month(CAL_GREGORIAN,date($month),date('Y')); $i++) @php
                                    $temp=($i < 9) ? '0' . ($i + 1) : ($i + 1) ; @endphp <th scope="col"
                                    class="text-center align-middle text-small" style="width: 2.5%;">
                                    @if ($month < date('m')) <a href="{{route('admin.presences.createOrEdit', [
                                            'id' => $class->id,
                                            'date' => $temp.'-'.date($month.'-Y'),
                                        ])}}">{{$temp}}</a>
                                        @else
                                        @if (($temp) <= date('d') && $month==date('m')) <a href="{{route('admin.presences.createOrEdit', [
                                            'id' => $class->id,
                                            'date' => $temp.'-'.date($month.'-Y'),
                                        ])}}">{{$temp}}</a>
                                            @else
                                            {{$temp}}
                                            @endif
                                            @endif

                                            </th>
                                            @endfor
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($class->students()->orderBy('name')->get() as $key => $student)
                            <tr>
                                <th class="text-center text-small" scope="row">{{$key + 1}}</th>
                                <td class="text-small"><a
                                        href="{{route('admin.students.show', $student->id)}}">{{$student->name}}</a>
                                </td>
                                @if ($student->presences()
                                ->where('date', 'like', '%-'.date($month.'-Y'))->get()->count() > 0)
                                @for ($i = 0; $i < cal_days_in_month(CAL_GREGORIAN,date($month),date('Y')); $i++) @php
                                    $temp=($i < 9) ? '0' . ($i + 1) : ($i + 1) ; @endphp @if($student->presences()
                                    ->where('date', $temp .'-'.date($month.'-Y'))->first() !== null)
                                    @switch($student->presences()
                                    ->where('date', $temp .'-'.date($month.'-Y'))
                                    ->first()->info)
                                    @case($month.'asuk')
                                    <td><i class="fas fa-check"></i></td>
                                    @break
                                    @case('Sakit')
                                    <td class="text-center align-middle text-small font-weight-bold">S</td>
                                    @break
                                    @case('Izin')
                                    <td class="text-center align-middle text-small font-weight-bold">I</td>
                                    @break
                                    @case('Alfa')
                                    <td class="text-center align-middle text-small font-weight-bold">A</td>
                                    @break
                                    @default
                                    <td class="text-center align-middle text-small font-weight-bold">-</td>
                                    @endswitch
                                    @else
                                    <td class="bg-secondary"></td>
                                    @endif
                                    @endfor
                                    @else
                                    @for ($i = 0; $i < cal_days_in_month(CAL_GREGORIAN,date($month),date('Y')); $i++)
                                        <td class="bg-secondary">
                                        </td>
                                        @endfor
                                        @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mb-3">
                    <b>Keterangan : </b>
                    <div class="row">
                        <div class="offset-1 col-2 text-center">
                            <svg width="20" height="20">
                                <rect width="20" height="20" style="fill:rgb(205,211,216);" />
                            </svg> : Belum diisi
                        </div>
                        <div class="col-2 text-center">
                            <i class="fas fa-check"></i> : Masuk
                        </div>
                        <div class="col-2 text-center">
                            S : Sakit
                        </div>
                        <div class="col-2 text-center">
                            I : Izin
                        </div>
                        <div class="col-2 text-center">
                            A : Alfa
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <b>Wali Kelas : </b>
                    @if (App\Teacher::where('homeroom_teacher_of', $class->id)->get()->count() > 0)
                    <a
                        href="{{ route('admin.teachers.show', App\Teacher::where('homeroom_teacher_of', $class->id)->first()->id) }}">
                        {{App\Teacher::where('homeroom_teacher_of', $class->id)->first()->name}}
                    </a>
                    @else
                    <span class="text-danger">
                        Belum Ada
                    </span>
                    @endif
                </div>
                @else
                <div>
                    <h4 class="text-center">Belum ada siswa di {{$class->name}}</h4>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
{{-- Libraries for specific page --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

{{-- Success Alert --}}
@if ($message = Session::get('success'))
<script>
    swal("Sukses!", "{{ $message }}", "success");
</script>
@endif
@endsection