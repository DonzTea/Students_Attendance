@extends('layouts.admin-master')

@section('title')
Data Siswa
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-social@5.1.1/bootstrap-social.min.css">
@endsection

@section('content')
<section class="section">
    <div class="section-header mb-5">
        <h1>{{$student->name}}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.students.index') }}">Data Siswa</a></div>
            <div class="breadcrumb-item">{{$student->name}}</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="{{$student->family == null ? 'offset-lg-3 offset-md-3' : ''}} col-lg-6 col-md-6 col-12">
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
                                    <div class="font-weight-bold text-danger">Data belum diisi</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="profile-widget-description">
                        <div class="profile-widget-name">
                            NIS :
                            {!!$student->nis ?: '<span class="text-danger">Data belum diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            NISN :
                            {!!$student->nisn ?: '<span class="text-danger">Data belum diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            Nama :
                            {!!$student->name ?: '<span class="text-danger">Data belum diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            Belajar di Kelas :
                            {!!$student->class_group_id ? $student->classGroup->name : '<span class="text-danger">Data
                                belum diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            Jenis Kelamin :
                            {!!$student->gender ?: '<span class="text-danger">Data belum diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            Kota Kelahiran : {!!
                            $student->region ?
                            $student->region->name : '<span class="text-danger">Data belum diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            Tanggal Lahir :
                            {!!$student->birthday ?: '<span class="text-danger">Data belum diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            Alamat :
                            {!!$student->address ?: '<span class="text-danger">Data belum diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            Orang Tua : {!!$student->studentParent ?
                            $student->studentParent->name : '<span class="text-danger">Data belum diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            Agama : {!!$student->religion ?
                            $student->religion->name : '<span class="text-danger">Data belum diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            Tinggi Badan :
                            {!!$student->height ?: '<span class="text-danger">Data belum diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            Berat Badan :
                            {!!$student->weight ?: '<span class="text-danger">Data belum diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            Dibuat : {{$student->created_at->diffForHumans()}}
                        </div>
                        <div class="profile-widget-name">
                            Terakhir diubah : {{$student->updated_at->diffForHumans()}}
                        </div>
                        <div class="text-right">
                            <a data-toggle="tooltip" title="" data-original-title="Edit"
                                class="btn btn-primary btn-action mr-1"
                                href="{{route('admin.students.edit', $student->id)}}">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <form id="delete_{{$student->id}}" class="d-inline"
                                action="{{route('admin.students.destroy', $student->id)}}" method="post">
                                @method('DELETE')
                                @csrf
                                <button data-id="delete_{{$student->id}}" data-toggle="tooltip" title=""
                                    data-original-title="Hapus" class="button_delete btn btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @if ($student->family)
            <div class="col-lg-6 col-md-6 col-12">
                <div class="card profile-widget">
                    <div class="profile-widget-description">
                        <h5 class="text-primary text-center mb-5">Data Terkait Keluarga</h5>
                        <div class="profile-widget-name">
                            Tinggal pada :
                            {!!$student->family->live_with ?: '<span class="text-danger">Data belum diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            Anak ke :
                            {!!$student->family->n_child ?: '<span class="text-danger">Data belum diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            Banyak Saudara Kandung :
                            {!!$student->family->siblings_count ?: '<span class="text-danger">Data belum
                                diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            Banyak Saudara Tiri :
                            {!!$student->family->step_brothers_count ?: '<span class="text-danger">Data belum
                                diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            Banyak Saudara Angkat :
                            {!!$student->family->adopted_brothers_count ?: '<span class="text-danger">Data belum
                                diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            Jumlah Saudara :
                            {!!$student->family->sibs_total ?: '<span class="text-danger">Data belum diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            Bahasa Sehari-hari :
                            {!!$student->family->used_language ?: '<span class="text-danger">Data belum diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            Keadaan Sosial Ekonomi :
                            {!!$student->family->economic_condition ?: '<span class="text-danger">Data belum
                                diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            Situasi Belajar di Rumah :
                            {!!$student->family->learning_condition ?: '<span class="text-danger">Data belum
                                diisi</span>'!!}
                        </div>
                    </div>
                </div>
            </div>
            @endif
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
            var student = $('form#' + id);
            
            swal({
                title: "Apakah anda yakin?",
                text: "Setelah dihapus data terpilih akan hilang.",
                icon: "warning",
                buttons: ["Tidak", "Ya"],
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    student.submit();
                } else {
                    swal("Data batal dihapus.", {
                        icon: "info",
                    });
                }
            });
        });
</script>
@endsection