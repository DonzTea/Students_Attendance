@extends('layouts.admin-master')

@section('title')
Data Kehadiran Tahun Pelajaran {{$year->name}} - {{$year->name + 1}}
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{$class->name}}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">
                <a href="{{ route('admin.historyPresences.schoolYears') }}">
                    Riwayat Kehadiran
                </a>
            </div>
            <div class="breadcrumb-item">
                <a href="{{ route('admin.historyPresences.index', $year->id) }}">
                    {{$year->name}} - {{$year->name + 1}}
                </a>
            </div>
            <div class="breadcrumb-item">
                <a href="{{ route('admin.historyPresences.months', [$year->id, $class->id]) }}">
                    {{$class->name}}
                </a>
            </div>
            <div class="breadcrumb-item">{{$month_name}}</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>Data Kehadiran Tahun Pelajaran {{$year->name}} - {{$year->name + 1}}</h4>
                @if ($isDownloadable)
                <div class="card-header-action">
                    <a href="{{route('admin.historyPresences.export', [
                        'id' => $year->id,
                        'class_id' => $class->id,
                        'month' => $month_index,
                        ])}}" class="btn btn-outline-success">
                        <i class="far fa-calendar-plus"></i> Download Excel
                    </a>
                </div>
                @endif
            </div>
            <div class="card-body">
                @if ($class->historyStudents()->where('school_year_id', $year->id)->get()->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-light">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="text-center align-middle" rowspan="3">NO</th>
                                <th scope="col" class="text-center align-middle" rowspan="3">Nama</th>
                                <th scope="col" class="text-center align-middle"
                                    colspan="{{cal_days_in_month(CAL_GREGORIAN, $month_index, $year->name)}}">
                                    Bulan {{$month_name.' Tahun '.$year->name}}
                                </th>
                            </tr>
                            <tr>
                                <th scope="col" class="text-center align-middle"
                                    colspan="{{cal_days_in_month(CAL_GREGORIAN, $month_index, $year->name)}}">Tanggal
                                </th>
                            </tr>
                            <tr>
                                @for ($i = 0; $i < cal_days_in_month(CAL_GREGORIAN, $month_index, $year->name); $i++)
                                    @php
                                    $temp=($i < 9) ? '0' . ($i + 1) : ($i + 1) ; @endphp <th scope="col"
                                        class="text-center align-middle text-small" style="width: 2.5%;">
                                        {{$i + 1}}
                                        </th>
                                        @endfor
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($class->historyStudents()
                            ->where('school_year_id', $year->id)->orderBy('name')->get() as $key => $student)
                            <tr>
                                <th class="text-center text-small" scope="row">{{$key + 1}}</th>
                                <td class="text-small"><a
                                        href="{{route('admin.historyStudents.show', [$student->id, $year->id])}}">{{$student->name}}</a>
                                </td>
                                @php
                                $by_month = substr($month_index, 0, 1) == '0' ? $month_index : '0'.$month_index;
                                @endphp
                                @if ($student->historyPresences()
                                ->where('date', 'like', '%-'.$by_month.'-'.$year->name)
                                ->get()->count() > 0)
                                @for ($i = 0; $i < cal_days_in_month(CAL_GREGORIAN, $month_index, $year->name); $i++)
                                    @php
                                    $temp=($i < 9) ? '0' . ($i + 1) : ($i + 1) ; @endphp @if($student ->
                                        historyPresences()
                                        ->where('date', $temp .'-'.$by_month.'-'.$year->name)->first() !== null)
                                        @switch($student->historyPresences()
                                        ->where('date', $temp .'-'.$by_month.'-'.$year->name)
                                        ->first()->info)
                                        @case('Masuk')
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
                                        @for ($i = 0; $i < cal_days_in_month(CAL_GREGORIAN, $month_index, $year->name);
                                            $i++) <td class="bg-secondary">
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
                            </svg> : Tidak diisi
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
                @else
                <div>
                    <h4 class="text-center">
                        {{$class->name}} tidak memiliki data kehadiran
                        <br>
                        pada bulan {{$month_name}} tahun pelajaran {{$year->name}} - {{$year->name + 1}}
                    </h4>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection