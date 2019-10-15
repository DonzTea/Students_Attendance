@extends('layouts.admin-master')

@section('title')
Tambah Guru
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/selectric@1.13.0/public/selectric.css">
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Tambah Guru</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.teachers.index') }}">Data Guru</a></div>
            <div class="breadcrumb-item">Tambah Guru</div>
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

                <form action="{{ route('admin.teachers.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Nama Lengkap <span class="text-danger">*</span></label>
                                <input name="name" class="form-control" placeholder="contoh : Caca Iryana S.Pd. SD"
                                    value="{{old('name')}}">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <div class="control-label">Jenis Kelamin <span class="text-danger">*</span></div>
                                <div class="custom-switches-stacked mt-2">
                                    <label class="custom-switch">
                                        <input type="radio" name="gender" value="L" class="custom-switch-input" checked
                                            {{old('gender') == 'L' ? 'checked' : ''}}>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Laki-laki</span>
                                    </label>
                                    <label class="custom-switch">
                                        <input type="radio" name="gender" value="P" class="custom-switch-input"
                                            {{old('gender') == 'P' ? 'checked' : ''}}>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Perempuan</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>NIP <span class="text-danger">*</span></label>
                                <input name="nip" class="form-control" placeholder="contoh : 19610314 198305 1003"
                                    value="{{old('nip')}}">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Karpeg</label>
                                <input name="karpeg" class="form-control" placeholder="contoh : D720900"
                                    value="{{old('karpeg')}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Tanggal Lahir</label>
                                <input name="birthday" class="form-control datepicker" placeholder="Pilih Tanggal Lahir"
                                    autocomplete="off" value="{{old('birthday')}}">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Jabatan <span class="text-danger">*</span></label>
                                <select name="position_id" class="form-control selectric">
                                    <option value="" selected disabled>Pilih Jabatan</option>
                                    @foreach ($positions as $position)
                                    <option value="{{$position->id}}"
                                        {{old('position_id') == $position->id ? 'selected' : ''}}>{{$position->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <div class="control-label">Golongan</div>
                                <div class="row">
                                    <div class="col-6 col-md-6 col-lg-6">
                                        <div class="custom-switches-stacked mt-2">
                                            <label class="custom-switch">
                                                <input type="radio" name="type_1" value="I" class="custom-switch-input"
                                                    checked {{old('type_1') == 'I' ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">I</span>
                                            </label>
                                            <label class="custom-switch">
                                                <input type="radio" name="type_1" value="II" class="custom-switch-input"
                                                    {{old('type_1') == 'II' ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">II</span>
                                            </label>
                                            <label class="custom-switch">
                                                <input type="radio" name="type_1" value="III"
                                                    class="custom-switch-input"
                                                    {{old('type_1') == 'III' ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">III</span>
                                            </label>
                                            <label class="custom-switch">
                                                <input type="radio" name="type_1" value="IV" class="custom-switch-input"
                                                    {{old('type_1') == 'IV' ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">IV</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-6 col-lg-6">
                                        <div class="custom-switches-stacked mt-2">
                                            <label class="custom-switch">
                                                <input type="radio" name="type_2" value="A" class="custom-switch-input"
                                                    checked {{old('type_2') == 'A' ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">A</span>
                                            </label>
                                            <label class="custom-switch">
                                                <input type="radio" name="type_2" value="B" class="custom-switch-input"
                                                    {{old('type_2') == 'B' ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">B</span>
                                            </label>
                                            <label class="custom-switch">
                                                <input type="radio" name="type_2" value="C" class="custom-switch-input"
                                                    {{old('type_2') == 'C' ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">C</span>
                                            </label>
                                            <label class="custom-switch">
                                                <input type="radio" name="type_2" value="D" class="custom-switch-input"
                                                    {{old('type_2') == 'D' ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">D</span>
                                            </label>
                                            <label class="custom-switch">
                                                <input type="radio" name="type_2" value="E" class="custom-switch-input"
                                                    {{old('type_2') == 'E' ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">E</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 offset-md-3 col-lg-6  offset-md-3">
                            <div class="form-group">
                                <label>Mengajar di Kelas</label>
                                <select name="teached[]" class="form-control selectric" multiple="multiple">
                                    <option value="" selected disabled>Pilih Kelas</option>
                                    @foreach ($classes as $class)
                                    <option value="{{$class->id}}"
                                        {{ (collect(old('teached'))->contains($class->id)) ? 'selected' : '' }}>
                                        {{$class->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Wali dari Kelas</label>
                                <select name="homeroom_teacher_of" class="form-control selectric">
                                    <option value="" selected disabled>Pilih Kelas</option>
                                    @foreach ($classes as $class)
                                    <option value="{{$class->id}}"
                                        {{old('homeroom_teacher_of') == $class->id ? 'selected' : ''}}>{{$class->name}}
                                    </option>
                                    @endforeach
                                    <option value="0">Bukan wali kelas</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-primary w-25" type="submit">Tambah</button>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.id.min.js">
</script>

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
@endsection