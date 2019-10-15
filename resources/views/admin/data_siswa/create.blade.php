@extends('layouts.admin-master')

@section('title')
Tambah Siswa
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/selectric@1.13.0/public/selectric.css">
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Tambah Siswa</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.students.index') }}">Data Siswa</a></div>
            <div class="breadcrumb-item">Tambah Siswa</div>
        </div>
    </div>

    <form action="{{ route('admin.students.store') }}" method="post">
        @csrf
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
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>NIS <span class="text-danger">*</span></label>
                                <input name="nis" class="form-control" placeholder="contoh : 14501009"
                                    value="{{old('nis')}}">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>NISN <span class="text-danger">*</span></label>
                                <input name="nisn" class="form-control" placeholder="contoh : 0099558200"
                                    value="{{old('nisn')}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Nama Lengkap <span class="text-danger">*</span></label>
                                <input name="name" class="form-control" placeholder="contoh : Muhammad Rizqi Nur Akbar"
                                    value="{{old('name')}}">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <div class="control-label">Jenis Kelamin <span class="text-danger">*</span>
                                        </div>
                                        <div class="custom-switches-stacked mt-2">
                                            <label class="custom-switch">
                                                <input type="radio" name="gender" value="L" class="custom-switch-input"
                                                    checked {{old('gender') == 'L' ? 'checked' : ''}}>
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
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Kota Kelahiran</label>
                                <select name="region_id" class="select2 w-100" data-width="100%">
                                    <option value="" selected disabled>Pilih Kota</option>
                                    @foreach ($regions as $region)
                                    <option value="{{$region->id}}"
                                        {{old('region_id') == $region->id ? 'selected' : ''}}>
                                        {{$region->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Tanggal Lahir</label>
                                <input name="birthday" class="form-control datepicker" placeholder="Pilih Tanggal Lahir"
                                    autocomplete="off" value="{{old('birthday')}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Alamat</label>
                                <input name="address" class="form-control"
                                    placeholder="contoh : Dusun Gendereh, Sumedang" value="{{old('address')}}">
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
                                        {{old('religion_id') == $religion->id ? 'selected' : ''}}>
                                        {{$religion->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Orang Tua</label>
                                <select name="parent_id" class="select2 w-100" data-width="100%">
                                    <option value="" selected disabled>Pilih Orang Tua</option>
                                    @foreach ($parents as $parent)
                                    <option value="{{$parent->id}}"
                                        {{old('parent_id') == $parent->id ? 'selected' : ''}}>
                                        {{$parent->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Tinggi Badan (cm)</label>
                                <input name="height" class="form-control" placeholder="contoh : 120" type="number"
                                    min="0" value="{{old('height')}}">
                            </div>
                            <div class="form-group">
                                <label>Berat Badan (Kg)</label>
                                <input name="weight" class="form-control" placeholder="contoh : 40" type="number"
                                    min="0" value="{{old('weight')}}">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <div class="control-label">Belajar di Kelas <span class="text-danger">*</span></div>
                                <div class="custom-switches-stacked mt-2">
                                    @foreach ($classes as $key => $class)
                                    <label class="custom-switch">
                                        <input type="radio" name="class_id" value="{{$class->id}}"
                                            class="custom-switch-input" @if (old('class_id'))
                                            {{old('class_id') == $class->id ? 'checked' : ''}} @else
                                            {{$key == 0 ? 'checked' : ''}} @endif>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">{{$class->name}}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>Data Keluarga</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <div class="control-label">Tinggal Pada</div>
                                        <div class="custom-switches-stacked mt-2">
                                            <label class="custom-switch">
                                                <input type="radio" name="live_with" value="Ayah Ibu"
                                                    class="custom-switch-input"
                                                    {{old('live_with') == 'Ayah Ibu' ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">Ayah Ibu</span>
                                            </label>
                                            <label class="custom-switch">
                                                <input type="radio" name="live_with" value="Ayah"
                                                    class="custom-switch-input"
                                                    {{old('live_with') == 'Ayah' ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">Ayah</span>
                                            </label>
                                            <label class="custom-switch">
                                                <input type="radio" name="live_with" value="Ibu"
                                                    class="custom-switch-input"
                                                    {{old('live_with') == 'Ibu' ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">Ibu</span>
                                            </label>
                                            <label class="custom-switch">
                                                <input type="radio" name="live_with" value="Orang Lain"
                                                    class="custom-switch-input"
                                                    {{old('live_with') == 'Orang Lain' ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">Orang Lain</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <div class="control-label">Keadaan Sosial Ekonomi</div>
                                        <div class="custom-switches-stacked mt-2">
                                            <label class="custom-switch">
                                                <input type="radio" name="economic_condition" value="Sangat Baik"
                                                    class="custom-switch-input"
                                                    {{old('economic_condition') == 'Sangat Baik' ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">Sangat Baik</span>
                                            </label>
                                            <label class="custom-switch">
                                                <input type="radio" name="economic_condition" value="Baik"
                                                    class="custom-switch-input"
                                                    {{old('economic_condition') == 'Baik' ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">Baik</span>
                                            </label>
                                            <label class="custom-switch">
                                                <input type="radio" name="economic_condition" value="Cukup Baik"
                                                    class="custom-switch-input"
                                                    {{old('economic_condition') == 'Cukup Baik' ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">Cukup Baik</span>
                                            </label>
                                            <label class="custom-switch">
                                                <input type="radio" name="economic_condition" value="Kurang"
                                                    class="custom-switch-input"
                                                    {{old('economic_condition') == 'Kurang' ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">Kurang</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <div class="control-label">Situasi Belajar di Rumah</div>
                                        <div class="custom-switches-stacked mt-2">
                                            <label class="custom-switch">
                                                <input type="radio" name="learning_condition" value="Baik"
                                                    class="custom-switch-input"
                                                    {{old('learning_condition') == 'Baik' ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">Baik</span>
                                            </label>
                                            <label class="custom-switch">
                                                <input type="radio" name="learning_condition" value="Cukup"
                                                    class="custom-switch-input"
                                                    {{old('learning_condition') == 'Cukup' ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">Cukup</span>
                                            </label>
                                            <label class="custom-switch">
                                                <input type="radio" name="learning_condition" value="Kurang"
                                                    class="custom-switch-input"
                                                    {{old('learning_condition') == 'Kurang' ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">Kurang</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Anak Nomor ke</label>
                                        <input name="n_child" class="form-control" placeholder="contoh : 3"
                                            type="number" min="1" value="{{old('n_child')}}">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Banyaknya Saudara Kandung</label>
                                        <input name="siblings_count" class="form-control" placeholder="contoh : 1"
                                            type="number" min="0" value="{{old('siblings_count')}}">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Banyaknya Saudara Tiri</label>
                                        <input name="step_brothers_count" class="form-control" placeholder="contoh : 2"
                                            type="number" min="0" value="{{old('step_brothers_count')}}">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Banyaknya Saudara Angkat</label>
                                        <input name="adopted_brothers_count" class="form-control"
                                            placeholder="contoh : 3" type="number" min="0"
                                            value="{{old('adopted_brothers_count')}}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Bahasa Sehari-hari</label>
                                <input name="used_language" class="form-control" placeholder="contoh : Sunda"
                                    value="{{old('used_language')}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center">
            <button class="btn btn-primary w-25" type="submit">Tambah</button>
            <button class="btn btn-secondary w-25" type="reset">Batal</button>
        </div>
    </form>
</section>
@endsection

@section('scripts')
{{-- Libraries for specific page --}}
<script src="https://cdn.jsdelivr.net/npm/selectric@1.13.0/public/jquery.selectric.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.id.min.js">
</script>
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