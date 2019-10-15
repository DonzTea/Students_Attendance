@extends('layouts.admin-master')

@section('title')
Data Siswa Tahun Pelajaran {{$year->name}} - {{$year->name + 1}}
@endsection

@section('content')
<section class="section">
    <div class="section-header mb-5">
        <h1>{{$student->name}}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.historyStudents.index', $year->id) }}">Data Siswa
                    {{$year->name}} - {{$year->name + 1}}</a></div>
            <div class="breadcrumb-item">{{$student->name}} Tahun Pelajaran {{$year->name}} - {{$year->name + 1}}</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="offset-lg-3 col-lg-6 offset-md-3 col-md-6 col-12">
                <div class="card profile-widget">
                    <div class="profile-widget-header">
                        <img alt="image" src="{{asset('assets/img/avatar/avatar-1.png')}}"
                            class="rounded-circle profile-widget-picture">
                        <div class="profile-widget-items">
                            <div class="profile-widget-item text-right mr-3">
                                <div class="profile-widget-item-label">Anak dari :</div>
                                <div class="profile-widget-item-value">
                                    @if ($student->student_parent_id)
                                    <a href="{{route('admin.parents.show', $student->studentParent->id)}}"
                                        class="font-weight-bold">
                                        {{$student->studentParent->name}}
                                    </a>
                                    @else
                                    <div class="font-weight-bold text-danger">Tidak memiliki catatan orang tua</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="profile-widget-description">
                        <div class="profile-widget-name">
                            NIS :
                            {!!$student->nis ?: '<span class="text-danger">Data tidak diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            NISN :
                            {!!$student->nisn ?: '<span class="text-danger">Data tidak diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            Nama :
                            {!!$student->name ?: '<span class="text-danger">Data tidak diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            Belajar di Kelas :
                            {!!$student->class_group_id ? $student->classGroup->name : '<span class="text-danger">Data
                                tidak diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            Jenis Kelamin :
                            {!!$student->gender ?: '<span class="text-danger">Data tidak diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            Kota Kelahiran : {!!
                            $student->region ?
                            $student->region->name : '<span class="text-danger">Data tidak diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            Tanggal Lahir :
                            {!!$student->birthday ?: '<span class="text-danger">Data tidak diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            Alamat :
                            {!!$student->address ?: '<span class="text-danger">Data tidak diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            Orang Tua : {!!$student->studentParent ?
                            $student->studentParent->name : '<span class="text-danger">Data tidak diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            Agama : {!!$student->religion ?
                            $student->religion->name : '<span class="text-danger">Data tidak diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            Tinggi Badan :
                            {!!$student->height ?: '<span class="text-danger">Data tidak diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            Berat Badan :
                            {!!$student->weight ?: '<span class="text-danger">Data tidak diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            Dibuat : {{$student->created_at->diffForHumans()}}
                        </div>
                        <div class="profile-widget-name">
                            Terakhir diubah : {{$student->updated_at->diffForHumans()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection