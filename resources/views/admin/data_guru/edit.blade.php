@extends('layouts.admin-master')

@section('title')
Edit Data Guru
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/selectric@1.13.0/public/selectric.css">
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Edit Data Guru</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.teachers.index') }}">Data Guru</a></div>
            <div class="breadcrumb-item">Edit Data Guru</a></div>
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

                <form action="{{ route('admin.teachers.update', $teacher->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Nama Lengkap <span class="text-danger">*</span></label>
                                <input name="name" class="form-control" value="{{$teacher->name}}"
                                    placeholder="contoh : Caca Iryana S.Pd. SD">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <div class="control-label">Jenis Kelamin <span class="text-danger">*</span></div>
                                <div class="custom-switches-stacked mt-2">
                                    <label class="custom-switch">
                                        <input type="radio" name="gender" value="L" class="custom-switch-input"
                                            {{$teacher->gender == 'Laki-laki' ? 'checked' : ''}}>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Laki-laki</span>
                                    </label>
                                    <label class="custom-switch">
                                        <input type="radio" name="gender" value="P" class="custom-switch-input"
                                            {{$teacher->gender == 'Perempuan' ? 'checked' : ''}}>
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
                                <input name="nip" class="form-control" value="{{$teacher->nip}}"
                                    placeholder="contoh : 19610314 198305 1003">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Karpeg</label>
                                <input name="karpeg" class="form-control" value="{{$teacher->karpeg}}"
                                    placeholder="contoh : D720900">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Tanggal Lahir</label>
                                <input name="birthday" class="form-control datepicker" value="{{$teacher->birthday}}"
                                    placeholder="Pilih Tanggal Lahir" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Jabatan <span class="text-danger">*</span></label>
                                <select name="position_id" class="form-control selectric">
                                    @foreach ($positions as $position)
                                    <option value="{{$position->id}}"
                                        {{ $teacher->position->id == $position->id ? 'selected' : '' }}>
                                        {{$position->name}}</option>
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
                                                    {{substr($teacher->type, 0, -4) == 'I' ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">I</span>
                                            </label>
                                            <label class="custom-switch">
                                                <input type="radio" name="type_1" value="II" class="custom-switch-input"
                                                    {{substr($teacher->type, 0, -4) == 'II' ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">II</span>
                                            </label>
                                            <label class="custom-switch">
                                                <input type="radio" name="type_1" value="III"
                                                    class="custom-switch-input"
                                                    {{substr($teacher->type, 0, -4) == 'III' ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">III</span>
                                            </label>
                                            <label class="custom-switch">
                                                <input type="radio" name="type_1" value="IV" class="custom-switch-input"
                                                    {{substr($teacher->type, 0, -4) == 'IV' ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">IV</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-6 col-lg-6">
                                        <div class="custom-switches-stacked mt-2">
                                            <label class="custom-switch">
                                                <input type="radio" name="type_2" value="A" class="custom-switch-input"
                                                    {{substr($teacher->type, strlen($teacher->type) - 1, 1) == 'A' ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">A</span>
                                            </label>
                                            <label class="custom-switch">
                                                <input type="radio" name="type_2" value="B" class="custom-switch-input"
                                                    {{substr($teacher->type, strlen($teacher->type) - 1, 1) == 'B' ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">B</span>
                                            </label>
                                            <label class="custom-switch">
                                                <input type="radio" name="type_2" value="C" class="custom-switch-input"
                                                    {{substr($teacher->type, strlen($teacher->type) - 1, 1) == 'C' ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">C</span>
                                            </label>
                                            <label class="custom-switch">
                                                <input type="radio" name="type_2" value="D" class="custom-switch-input"
                                                    {{substr($teacher->type, strlen($teacher->type) - 1, 1) == 'D' ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">D</span>
                                            </label>
                                            <label class="custom-switch">
                                                <input type="radio" name="type_2" value="E" class="custom-switch-input"
                                                    {{substr($teacher->type, strlen($teacher->type) - 1, 1) == 'E' ? 'checked' : ''}}>
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
                                    <option value="{{$class->id}}" @foreach ($teacher->classGroups as $teached_class)
                                        {{$class->id == $teached_class->id ? 'selected' : ''}}
                                        @endforeach
                                        >{{$class->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Wali dari Kelas</label>
                                <select name="homeroom_teacher_of" class="form-control selectric">
                                    <option value="" selected disabled>Pilih Kelas</option>
                                    @foreach ($classes as $class)
                                    <option value="{{$class->id}}"
                                        {{ $teacher->homeroom_teacher_of == $class->id ? 'selected' : ''}}>
                                        {{$class->name}}
                                    </option>
                                    @endforeach
                                    <option value="0">Bukan Wali Kelas</option>
                                </select>
                            </div>
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