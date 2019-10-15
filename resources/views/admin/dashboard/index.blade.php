@extends('layouts.admin-master')

@section('title')
Dashboard
@endsection

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Dashboard</h1>
    <div class="section-header-breadcrumb">
      @if ($has_last_year && $has_last_year_history == false)
      <button id="button_new_school_year" class="btn btn-primary">
        <i class="far fa-calendar-plus"></i> Tahun Pelajaran Baru
      </button>
      @endif
    </div>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-primary">
            <i class="fas fa-chalkboard-teacher"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Guru</h4>
            </div>
            <div class="card-body">
              {{$teachers->count()}} orang
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-danger">
            <i class="fas fa-users"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Siswa</h4>
            </div>
            <div class="card-body">
              {{$students->count()}} orang
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-warning">
            <i class="fas fa-school"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Kelas</h4>
            </div>
            <div class="card-body">
              6 kelas
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-success">
            <i class="far fa-calendar-check"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Tahun Pelajaran</h4>
            </div>
            <div class="card-body">
              {{date('Y')}}-{{date('Y') + 1}}
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-4 col-md-12 col-12 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h4>Jumlah Siswa <br>Tahun Pelajaran {{date("Y")}} - {{date("Y") + 1}}</h4>
          </div>
          <div class="card-body">
            @foreach ($classes as $class)
            <div class="mb-4">
              <div class="text-small float-right font-weight-bold text-muted">
                {{$class->students()->count()}} orang
              </div>
              <div class="font-weight-bold mb-1">{{$class->name}}</div>
              <div class="progress" data-height="3" style="height: 3px;">
                <div class="progress-bar bg-primary" role="progressbar" data-width="
                {{$class->students()->count() > 0 ? ($class->students()->count() / $students->count() * 100) : 0}}%"
                  aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"
                  style="width: 
                  {{$class->students()->count() > 0 ? ($class->students()->count() / $students->count() * 100) : 0}}%;"></div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-12 col-12 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h4>Jumlah Guru <br>Tahun Pelajaran {{date("Y")}} - {{date("Y") + 1}}</h4>
          </div>
          <div class="card-body">
            @foreach ($classes as $class)
            <div class="mb-4">
              <div class="text-small float-right font-weight-bold text-muted">
                {{$class->teachers()->count()}} orang
              </div>
              <div class="font-weight-bold mb-1">{{$class->name}}</div>
              <div class="progress" data-height="3" style="height: 3px;">
                <div class="progress-bar bg-dark" role="progressbar" data-width="
                {{$class->teachers()->count() > 0 ? ($class->teachers()->count() / $teachers->count() * 100) : 0}}%"
                  aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"
                  style="width: 
                  {{$class->teachers()->count() > 0 ? ($class->teachers()->count() / $teachers->count() * 100) : 0}}%;"></div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-12 col-12 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h4>Jumlah Masuk Bulan {{$month}}<br>Tahun Pelajaran {{date("Y")}} - {{date("Y") + 1}}</h4>
          </div>
          <div class="card-body">
            @foreach ($classes as $class)
            @php
            $interval = abs(strtotime(date('d-m-Y')) - strtotime(date('01-m-Y')));
            $years = floor($interval / (365*60*60*24));
            $months = floor(($interval - $years * 365*60*60*24) / (30*60*60*24));
            $days = floor(($interval - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
            $max_presence = ( $days + 1 ) * $class->students()->count();

            $target_count = $class->presences()
            ->where('date', 'like', '%-'.date('m-Y'))
            ->where('info', 'Masuk')->get()->count();

            $max_presence == 0 ? $percentage = 0 : $percentage = $target_count / $max_presence * 100;
            @endphp
            <div class="mb-4">
              <div class="text-small float-right font-weight-bold text-muted">
                {{$target_count}}
              </div>
              <div class="font-weight-bold mb-1">{{$class->name}}</div>
              <div class="progress" data-height="3" style="height: 3px;">
                <div class="progress-bar bg-success" role="progressbar" data-width="{{$percentage}}%" aria-valuenow="80"
                  aria-valuemin="0" aria-valuemax="100" style="width: {{$percentage}}%;"></div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-4 col-md-12 col-12 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h4>Jumlah Sakit Bulan {{$month}}<br>Tahun Pelajaran {{date("Y")}} - {{date("Y") + 1}}</h4>
          </div>
          <div class="card-body">
            @foreach ($classes as $class)
            @php
            $interval = abs(strtotime(date('d-m-Y')) - strtotime(date('01-m-Y')));
            $years = floor($interval / (365*60*60*24));
            $months = floor(($interval - $years * 365*60*60*24) / (30*60*60*24));
            $days = floor(($interval - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
            $max_presence = ( $days + 1 ) * $class->students()->count();

            $target_count = $class->presences()
            ->where('date', 'like', '%-'.date('m-Y'))
            ->where('info', 'Sakit')->get()->count();

            $max_presence == 0 ? $percentage = 0 : $percentage = $target_count / $max_presence * 100;
            @endphp
            <div class="mb-4">
              <div class="text-small float-right font-weight-bold text-muted">
                {{$target_count}}
              </div>
              <div class="font-weight-bold mb-1">{{$class->name}}</div>
              <div class="progress" data-height="3" style="height: 3px;">
                <div class="progress-bar bg-info" role="progressbar" data-width="{{$percentage}}%" aria-valuenow="80"
                  aria-valuemin="0" aria-valuemax="100" style="width: {{$percentage}}%;"></div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-12 col-12 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h4>Jumlah Izin Bulan {{$month}}<br>Tahun Pelajaran {{date("Y")}} - {{date("Y") + 1}}</h4>
          </div>
          <div class="card-body">
            @foreach ($classes as $class)
            @php
            $interval = abs(strtotime(date('d-m-Y')) - strtotime(date('01-m-Y')));
            $years = floor($interval / (365*60*60*24));
            $months = floor(($interval - $years * 365*60*60*24) / (30*60*60*24));
            $days = floor(($interval - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
            $max_presence = ( $days + 1 ) * $class->students()->count();

            $target_count = $class->presences()
            ->where('date', 'like', '%-'.date('m-Y'))
            ->where('info', 'Izin')->get()->count();

            $max_presence == 0 ? $percentage = 0 : $percentage = $target_count / $max_presence * 100;
            @endphp
            <div class="mb-4">
              <div class="text-small float-right font-weight-bold text-muted">
                {{$target_count}}
              </div>
              <div class="font-weight-bold mb-1">{{$class->name}}</div>
              <div class="progress" data-height="3" style="height: 3px;">
                <div class="progress-bar bg-warning" role="progressbar" data-width="{{$percentage}}%" aria-valuenow="80"
                  aria-valuemin="0" aria-valuemax="100" style="width: {{$percentage}}%;"></div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-12 col-12 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h4>Jumlah Alfa Bulan {{$month}}<br>Tahun Pelajaran {{date("Y")}} - {{date("Y") + 1}}</h4>
          </div>
          <div class="card-body">
            @foreach ($classes as $class)
            @php
            $interval = abs(strtotime(date('d-m-Y')) - strtotime(date('01-m-Y')));
            $years = floor($interval / (365*60*60*24));
            $months = floor(($interval - $years * 365*60*60*24) / (30*60*60*24));
            $days = floor(($interval - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
            $max_presence = ( $days + 1 ) * $class->students()->count();

            $target_count = $class->presences()
            ->where('date', 'like', '%-'.date('m-Y'))
            ->where('info', 'Alfa')->get()->count();

            $max_presence == 0 ? $percentage = 0 : $percentage = $target_count / $max_presence * 100;
            @endphp
            <div class="mb-4">
              <div class="text-small float-right font-weight-bold text-muted">
                {{$target_count}}
              </div>
              <div class="font-weight-bold mb-1">{{$class->name}}</div>
              <div class="progress" data-height="3" style="height: 3px;">
                <div class="progress-bar bg-danger" role="progressbar" data-width="{{$percentage}}%" aria-valuenow="80"
                  aria-valuemin="0" aria-valuemax="100" style="width: {{$percentage}}%;"></div>
              </div>
            </div>
            @endforeach
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

{{-- Success Alert --}}
@if ($message = Session::get('success'))
<script>
  swal("Sukses!", "{{ $message }}", "success");
</script>
@endif

{{-- Add new school year confirmation --}}
<script>
  $(document).on("click", "#button_new_school_year", function(e) {
          e.preventDefault();
          
          swal({
              title: "Apakah anda yakin?",
              text: "Setelah memasuki tahun pelajaran baru, data yang terlibat tahun pelajaran sebelumnya akan berubah.",
              icon: "warning",
              buttons: ["Tidak", "Ya"],
              dangerMode: true,
          })
          .then((willDelete) => {
              if (willDelete) {
                window.location = "{{route('admin.dashboard.new_school_year')}}";
              } else {
                  swal("Batal memasuki tahun pelajaran baru.", {
                      icon: "info",
                  });
              }
          });
      });
</script>
@endsection