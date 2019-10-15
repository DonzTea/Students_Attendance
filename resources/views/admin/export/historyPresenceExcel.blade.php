<table>
    <thead>
        <tr>
            <th colspan="{{cal_days_in_month(CAL_GREGORIAN, $month_index, $year->name) + 9}}">
                <b>DAFTAR HADIR SISWA</b>
            </th>
        </tr>
        <tr>
            <th colspan="{{cal_days_in_month(CAL_GREGORIAN, $month_index, $year->name) + 9}}">
                <b>{{env('APP_NAME')}}</b>
            </th>
        </tr>
        <tr>
            <th colspan="{{cal_days_in_month(CAL_GREGORIAN, $month_index, $year->name) + 9}}">
                <b>TAHUN PELAJARAN {{$year->name}} - {{$year->name + 1}}</b>
            </th>
        </tr>
        <tr>
            <th colspan="{{cal_days_in_month(CAL_GREGORIAN, $month_index, $year->name) + 9}}"></th>
        </tr>
        <tr>
            <th rowspan="3">NO</th>
            <th rowspan="3">NISN</th>
            <th rowspan="3">NIS</th>
            <th rowspan="3">Nama</th>
            <th rowspan="3">L / P</th>
            <th colspan="{{cal_days_in_month(CAL_GREGORIAN, $month_index, $year->name)}}">
                Bulan {{$month_name.' '.$year->name}}
            </th>
            <th rowspan="2" colspan="4">Tidak Hadir</th>
        </tr>
        <tr>
            <th colspan="{{cal_days_in_month(CAL_GREGORIAN, $month_index, $year->name)}}">
                Tanggal
            </th>
        </tr>
        <tr>
            @for ($i = 0; $i < cal_days_in_month(CAL_GREGORIAN, $month_index, $year->name); $i++) @php $temp=($i < 9)
                    ? '0' . ($i + 1) : ($i + 1) ; @endphp <th>
                    {{$i + 1}}
                    </th>
                    @endfor
                    <th>S</th>
                    <th>I</th>
                    <th>A</th>
                    <th>Jml</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($class->historyStudents()
        ->where('school_year_id', $year->id)->orderBy('name')->get() as $key => $student)
        <tr>
            <th scope="row">{{$key + 1}}</th>
            <td>{{$student->nisn}}</td>
            <td>{{$student->nis}}</td>
            <td>{{$student->name}}</td>
            <td>{{$student->gender == 'Laki-laki' ? 'L' : 'P'}}</td>
            @php $by_month = $month_index < 10 ? '0' . $month_index : $month_index ; @endphp @if ($student->
                historyPresences()
                ->where('date', 'like', '%-'.date($by_month.'-'.$year->name))->get()->count() > 0)
                @for ($i = 0; $i < cal_days_in_month(CAL_GREGORIAN, $month_index, $year->name); $i++)
                    @php $temp=($i < 9) ? '0' . ($i + 1) : ($i + 1) ; @endphp @if($student->historyPresences()
                        ->where('date', $temp .'-'.date($by_month.'-'.$year->name))->first() !== null)
                        @switch($student->historyPresences()
                        ->where('date', $temp .'-'.date($by_month.'-'.$year->name))
                        ->first()->info)
                        @case('Masuk')
                        <td><b>.</b></td>
                        @break
                        @case('Sakit')
                        <td>S</td>
                        @break
                        @case('Izin')
                        <td>I</td>
                        @break
                        @case('Alfa')
                        <td>A</td>
                        @break
                        @default
                        <td></td>
                        @endswitch
                        @else
                        <td></td>
                        @endif
                        @endfor
                        @else
                        @for ($i = 0; $i < cal_days_in_month(CAL_GREGORIAN, $month_index, $year->name); $i++) <td>
                            </td>
                            @endfor
                            @endif
                            <td>{{$student->historyPresences()
                            ->where('date', 'like', '%-'.$by_month.'-'.$year->name)
                            ->where('info', 'Sakit')->get()->count() == 0 ? '-' : 
                            $student->historyPresences()
                            ->where('date', 'like', '%-'.$by_month.'-'.$year->name)
                            ->where('info', 'Sakit')->get()->count()}}</td>
                            <td>{{$student->historyPresences()
                            ->where('date', 'like', '%-'.$by_month.'-'.$year->name)
                            ->where('info', 'Izin')->get()->count() == 0 ? '-' :
                            $student->historyPresences()
                            ->where('date', 'like', '%-'.$by_month.'-'.$year->name)
                            ->where('info', 'Izin')->get()->count()}}</td>
                            <td>{{$student->historyPresences()
                            ->where('date', 'like', '%-'.$by_month.'-'.$year->name)
                            ->where('info', 'Alfa')->get()->count() == 0 ? '-' :
                            $student->historyPresences()
                            ->where('date', 'like', '%-'.$by_month.'-'.$year->name)
                            ->where('info', 'Alfa')->get()->count()}}</td>
                            <td>{{$student->historyPresences()
                            ->where('date', 'like', '%-'.$by_month.'-'.$year->name)
                            ->where('info', 'Sakit')->get()->count() + 
                            $student->historyPresences()
                            ->where('date', 'like', '%-'.$by_month.'-'.$year->name)
                            ->where('info', 'Izin')->get()->count() + 
                            $student->historyPresences()
                            ->where('date', 'like', '%-'.$by_month.'-'.$year->name)
                            ->where('info', 'Alfa')->get()->count()
                            }}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="5">Jumlah Tidak Hadir</td>
            @for ($i = 0; $i < cal_days_in_month(CAL_GREGORIAN, $month_index, $year->name); $i++)
                @php $temp=($i < 9) ? '0' . ($i + 1) : ($i + 1) ; @endphp <td>
                    {{App\HistoryPresence::where('date', $temp .'-'.date($by_month.'-'.$year->name))
                    ->where('info', '!=', 'Masuk')->get()->count() == 0 ? '-' : 
                    App\HistoryPresence::where('date', $temp .'-'.date($by_month.'-'.$year->name))
                    ->where('info', '!=', 'Masuk')->get()->count()}}
                    </td>
                    @endfor
                    @php
                    $count_S = 0;
                    @endphp
                    @foreach ($year->classGroups()->find($class->id)->historyStudents as $item)
                    @php
                    $count_S += $item->historyPresences()->where('info', 'Sakit')->get()->count()
                    @endphp
                    @endforeach
                    <td>{{$count_S}}</td>
                    @php
                    $count_I = 0;
                    @endphp
                    @foreach ($year->classGroups()->find($class->id)->historyStudents as $item)
                    @php
                    $count_I += $item->historyPresences()->where('info', 'Izin')->get()->count()
                    @endphp
                    @endforeach
                    <td>{{$count_I}}</td>
                    @php
                    $count_A = 0;
                    @endphp
                    @foreach ($year->classGroups()->find($class->id)->historyStudents as $item)
                    @php
                    $count_A += $item->historyPresences()->where('info', 'Alfa')->get()->count()
                    @endphp
                    @endforeach
                    <td>{{$count_A}}</td>
                    <td>{{$count_S + $count_I + $count_A}}</td>
        </tr>
        <tr>
        </tr>
        <tr>
            <td></td>
            <td colspan="2">Mengetahui,</td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2">Kepala Sekolah,</td>
            <td colspan="{{cal_days_in_month(CAL_GREGORIAN, $month_index, $year->name) - 3}}"></td>
            <td colspan="8">Wali Kelas,</td>
        </tr>
        @for ($i = 0; $i < 3; $i++) <tr>
            </tr>
            @endfor
            <tr>
                <td></td>
                <td colspan="2">{{$headmaster->name}}</td>
                @for ($i = 0; $i < (cal_days_in_month(CAL_GREGORIAN, $month_index, $year->name) - 3); $i++)
                    <td></td>
                    @endfor
                    <td colspan="8">{{$teacher->name}}</td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2">NIP. {{$headmaster->nip}}</td>
                @for ($i = 0; $i < (cal_days_in_month(CAL_GREGORIAN, $month_index, $year->name) - 3); $i++)
                    <td></td>
                    @endfor
                    <td colspan="8">NIP. {{$teacher->nip}}</td>
            </tr>
    </tbody>
</table>