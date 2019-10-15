@extends('layouts.admin-master')

@section('title')
Data Guru Tahun Pelajaran {{$year->name}} - {{$year->name + 1}}
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-social@5.1.1/bootstrap-social.min.css">
@endsection

@section('content')
<section class="section">
    <div class="section-header mb-5">
        <h1>{{$teacher->name}}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">
                <a href="{{ route('admin.historyTeachers.index', $year->id) }}">
                    Data Guru Tahun Pelajaran {{$year->name}} - {{$year->name + 1}}
                </a>
            </div>
            <div class="breadcrumb-item">{{$teacher->name}}</div>
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
                                <div class="profile-widget-item-label">Jabatan :</div>
                                <div class="profile-widget-item-value">
                                    {{$teacher->position_id ? $teacher->position->name : ''}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="profile-widget-description">
                        <div class="profile-widget-name">
                            NIP : {!!$teacher->nip ?: '<span class="text-danger">Data tidak diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            Karpeg : {!!$teacher->karpeg ?: '<span class="text-danger">Data tidak diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            Nama : {!!$teacher->name ?: '<span class="text-danger">Data tidak diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            Tanggal Lahir :
                            {!!$teacher->birthday ?: '<span class="text-danger">Data tidak diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            Jabatan : {!!
                            $teacher->position_id ?
                            $teacher->position->name : '<span class="text-danger">Data tidak diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            Golongan : {!!$teacher->type ?: '<span class="text-danger">Data tidak diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            Wali dari Kelas : {!!$teacher->homeroom_teacher_of ?: '<span class="text-danger">Data tidak
                                diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            Mengajar di Kelas :
                            @if (count($teacher->classGroups))
                            <ul>
                                @foreach ($teacher->classGroups as $key => $class)
                                <li>{{$class->name}}</li>
                                @endforeach
                            </ul>
                            @else
                            <div class="font-weight-bold text-danger">Data tidak diisi</div>
                            @endif
                        </div>
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

{{-- Action button delete confirmation --}}
<script>
    $(document).on("click", ".button_delete", function(e) {
    
            e.preventDefault();
    
            var id = $(this).data("id");
            var teacher = $('form#' + id);
            
            swal({
                title: "Apakah anda yakin?",
                text: "Setelah dihapus data terpilih akan hilang.",
                icon: "warning",
                buttons: ["Tidak", "Ya"],
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    teacher.submit();
                } else {
                    swal("Data batal dihapus.", {
                        icon: "info",
                    });
                }
            });
        });
</script>
@endsection