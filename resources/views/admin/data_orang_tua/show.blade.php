@extends('layouts.admin-master')

@section('title')
Data Orang Tua
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-social@5.1.1/bootstrap-social.min.css">
@endsection

@section('content')
<section class="section">
    <div class="section-header mb-5">
        <h1>{{$parent->name}}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.parents.index') }}">Data Orang Tua</a></div>
            <div class="breadcrumb-item">{{$parent->name}}</div>
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
                                <div class="profile-widget-item-label">Orang Tua dari :</div>
                                <div class="profile-widget-item-value">
                                    @if (count($parent->students))
                                    @foreach ($parent->students as $key => $child)
                                    <a href="{{route('admin.students.show', $child->id)}}" class="font-weight-bold">
                                        {{$child->name}}
                                    </a>
                                    {{$key == count($parent->students) - 1 ? '' : ', '}}
                                    @endforeach
                                    @else
                                    <div class="font-weight-bold text-danger">Data belum diisi</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="profile-widget-description">
                        <div class="profile-widget-name">
                            Nama : {!!$parent->name?: '<span class="text-danger">Data belum diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            Umur : {!!$parent->age ? $parent->age.' Tahun' : '<span class="text-danger">Data belum
                                diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            Agama : {!!$parent->religion ?
                            $parent->religion->name : '<span class="text-danger">Data belum diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            Pendidikan Terakhir :
                            {!!$parent->education ?
                            $parent->education->name : '<span class="text-danger">Data belum diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            Pekerjaan : {!!$parent->profession?: '<span class="text-danger">Data belum diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">
                            Alamat : {!!$parent->address?: '<span class="text-danger">Data belum diisi</span>'!!}
                        </div>
                        <div class="profile-widget-name">Dibuat : {{$parent->created_at->diffForHumans()}}</div>
                        <div class="profile-widget-name">Terakhir diubah : {{$parent->updated_at->diffForHumans()}}
                        </div>
                        <div class="text-right">
                            <a data-toggle="tooltip" title="" data-original-title="Edit"
                                class="btn btn-primary btn-action mr-1"
                                href="{{route('admin.parents.edit', $parent->id)}}">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <form id="delete_{{$parent->id}}" class="d-inline"
                                action="{{route('admin.parents.destroy', $parent->id)}}" method="post">
                                @method('DELETE')
                                @csrf
                                <button data-id="delete_{{$parent->id}}" data-toggle="tooltip" title=""
                                    data-original-title="Hapus" class="button_delete btn btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
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