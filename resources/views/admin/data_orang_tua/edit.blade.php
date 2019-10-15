@extends('layouts.admin-master')

@section('title')
Edit Data Orang Tua
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/selectric@1.13.0/public/selectric.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Edit Data Orang Tua</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.parents.index') }}">Data Orang Tua</a></div>
            <div class="breadcrumb-item">Edit Data Orang Tua</a></div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>Data Pribadi</h4>
            </div>
            <div class="card-body">
                @if ($errors->any())
                <div id="alert" class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Pengisian Gagal.</strong> Ada kesalahan dalam pengisian data.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('admin.parents.update', $parent->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Nama Lengkap <span class="text-danger">*</span></label>
                                <input name="name" class="form-control" value="{{$parent->name}}"
                                    placeholder="contoh : Hendra Gunawan">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Umur (Tahun)</label>
                                <input name="age" class="form-control" value="{{$parent->age}}"
                                    placeholder="contoh : 49" type="number" min="1">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Agama</label>
                                <select name="religion_id" class="form-control selectric">
                                    <option value="" selected disabled>Pilih Agama</option>
                                    @foreach ($religions as $religion)
                                    <option value="{{$religion->id}}"
                                        {{$religion->id == $parent->religion_id ? 'selected' : ''}}>
                                        {{$religion->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Pendidikan Tertinggi</label>
                                <select name="education_id" class="form-control selectric">
                                    <option value="" selected disabled>Pilih Pendidikan</option>
                                    @foreach ($educations as $education)
                                    <option value="{{$education->id}}"
                                        {{$education->id == $parent->education_id ? 'selected' : ''}}>
                                        {{$education->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Pekerjaan</label>
                                <input name="profession" class="form-control" value="{{$parent->profession}}"
                                    placeholder="contoh : Petani">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Alamat</label>
                                <input name="address" class="form-control" value="{{$parent->address}}"
                                    placeholder="contoh : Dusun Gendereh, Sumedang">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Orang Tua dari</label>
                        <div>
                            <select class="select2 w-100" name="parent_of[]" multiple="multiple" data-width="100%">
                                @foreach ($students as $student)
                                <option value="{{$student->id}}" @if ($parent->students)
                                    @foreach ($parent->students as $child)
                                    {{ $student->id == $child->id ? 'selected' : '' }}
                                    @endforeach
                                    @endif
                                    >
                                    {{$student->name}}
                                    {{$student->address ? ', tinggal di '.$student->address : ''}}
                                    {{$student->birthday ? ', lahir pada '.$student->birthday : ''}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-primary w-25" type="submit">Simpan Perubahan</button>
                        <button class="btn btn-secondary w-25" type="reset">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
{{-- Libraries for specific page --}}
<script src="https://cdn.jsdelivr.net/npm/selectric@1.13.0/public/jquery.selectric.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>

{{-- Fade out alert --}}
<script>
    $(document).ready(function() {
        $("#alert").delay(5000).slideUp(750);
    });
</script>

{{-- Datepicker --}}
<script type="text/javascript">
    $('.datepicker').datepicker({  
       isRTL: false,
        format: 'dd-mm-yyyy',
        autoclose:true,
        language: 'id',
     });  
</script>

{{-- Select2 --}}
<script>
    $(document).ready(function() {
            $('.select2').select2();
        });
</script>
@endsection