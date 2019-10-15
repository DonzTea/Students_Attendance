<aside id="sidebar-wrapper">
  <div class="sidebar-brand">
    <a href="{{ route('admin.dashboard') }}">
      <img src="{{ asset('/assets/img/logo.png') }}" alt="{{ env('APP_NAME') }}" width="45">
      {{ env('APP_NAME') }}
    </a>
  </div>
  <div class="sidebar-brand sidebar-brand-sm">
    <a href="index.html">
      <img src="{{ asset('/assets/img/logo.png') }}" alt="{{ env('APP_NAME') }}" width="45">
    </a>
  </div>
  <ul class="sidebar-menu">

    <li class="menu-header">Dashboard</li>
    <li class="{{ Request::route()->getName() == 'admin.dashboard' ? ' active' : '' }}">
      <a class="nav-link" href="{{ route('admin.dashboard') }}">
        <i class="fas fa-columns"></i> <span>Dashboard</span>
      </a>
    </li>

    <li class="menu-header">Data</li>
    <li class="{{ 
      Request::route()->getName() == 'admin.teachers.index' ||
      Request::route()->getName() == 'admin.teachers.create' ||
      Request::route()->getName() == 'admin.teachers.edit' ||
      Request::route()->getName() == 'admin.teachers.show' || 
      Request::route()->getName() == 'admin.teachers.class' ? ' active' : '' 
    }}">
      <a class="nav-link" href="{{ route('admin.teachers.index') }}">
        <i class="fas fa-chalkboard-teacher"></i> <span>Data Guru</span>
      </a>
    </li>

    <li class="{{
      Request::route()->getName() == 'admin.parents.index' ||
      Request::route()->getName() == 'admin.parents.create' ||
      Request::route()->getName() == 'admin.parents.edit' ||
      Request::route()->getName() == 'admin.parents.show' ? ' active' : '' 
    }}">
      <a class="nav-link" href="{{route('admin.parents.index')}}">
        <i class="fas fa-user-tie"></i> <span>Data Orang Tua</span>
      </a>
    </li>

    <li class="{{
      Request::route()->getName() == 'admin.students.index' ||
      Request::route()->getName() == 'admin.students.create' ||
      Request::route()->getName() == 'admin.students.edit' ||
      Request::route()->getName() == 'admin.students.show' || 
      Request::route()->getName() == 'admin.students.class' ? ' active' : '' 
    }}">
      <a class="nav-link" href="{{route('admin.students.index')}}">
        <i class="fas fa-user-graduate"></i> <span>Data Siswa</span>
      </a>
    </li>

    <li class="{{
      Request::route()->getName() == 'admin.presences.index' ||
      Request::route()->getName() == 'admin.presences.createOrEdit' ||
      Request::route()->getName() == 'admin.presences.show' ? ' active' : '' }}">
      <a class="nav-link" href="{{route('admin.presences.index')}}">
        <i class="fas fa-clipboard-list"></i> <span>Data Kehadiran</span>
      </a>
    </li>

    <li class="menu-header">Riwayat</li>
    <li class="{{
      Request::route()->getName() == 'admin.historyTeachers.schoolYears' ||
      Request::route()->getName() == 'admin.historyTeachers.index' ||
      Request::route()->getName() == 'admin.historyTeachers.schoolYearClass' ||
      Request::route()->getName() == 'admin.historyTeachers.show' ? ' active' : '' 
    }}">
      <a class="nav-link" href="{{route('admin.historyTeachers.schoolYears')}}">
        <i class="fas fa-chalkboard-teacher"></i> <span>Riwayat Guru</span>
      </a>
    </li>
    <li class="{{
      Request::route()->getName() == 'admin.historyStudents.schoolYears' ||
      Request::route()->getName() == 'admin.historyStudents.index' ||
      Request::route()->getName() == 'admin.historyStudents.schoolYearClass' ||
      Request::route()->getName() == 'admin.historyStudents.show' ? ' active' : '' 
    }}">
      <a class="nav-link" href="{{route('admin.historyStudents.schoolYears')}}">
        <i class="fas fa-user-graduate"></i> <span>Riwayat Siswa</span>
      </a>
    </li>
    <li class="{{
      Request::route()->getName() == 'admin.historyPresences.schoolYears' ||
      Request::route()->getName() == 'admin.historyPresences.index' ||
      Request::route()->getName() == 'admin.historyPresences.months' ||
      Request::route()->getName() == 'admin.historyPresences.month' ? ' active' : '' 
    }}">
      <a class="nav-link" href="{{route('admin.historyPresences.schoolYears')}}">
        <i class="fas fa-book"></i> <span>Riwayat Kehadiran</span>
      </a>
    </li>
  </ul>
</aside>