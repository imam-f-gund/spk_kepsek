<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('img/logo.png') }}" width="25%">
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ url('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Data Master
    </div>

    <li class="nav-item">
        <a class="nav-link" href="{{ url('kriteria') }}">
            <i class="fas fa-code-branch"></i>
            <span>Kriteria</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('periode') }}">
            <i class="far fa-calendar-alt"></i>
            <span>Periode</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('kecamatan') }}">
            <i class="fas fa-city"></i>
            <span>Kecamatan</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('sekolah') }}">
            <i class="fas fa-school"></i>
            <span>Sekolah</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('kepsek') }}">
            <i class="fas fa-user-tie"></i>
            <span>Kepala Sekolah</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Penilaian
    </div>

    <li class="nav-item">
        <a class="nav-link" href="{{ url('penilaian') }}">
            <i class="fas fa-user-edit"></i>
            <span>Penilaian</span></a>
    </li>


    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true"
            aria-controls="collapsePages">
            <i class="fas fa-trophy"></i>
            <span>Perangkingan</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Jenis Perangkingan:</h6>
                <a class="collapse-item" href="{{ url('rangking/kecamatan') }}">Tingkat Kecamatan</a>
                <a class="collapse-item" href="{{ url('rangking/kabupaten') }}">Tingkat Kabupaten</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#laporan" aria-expanded="true"
            aria-controls="laporan">
            <i class="fas fa-file-alt"></i>
            <span>Laporan</span>
        </a>
        <div id="laporan" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Jenis Laporan:</h6>
                <a class="collapse-item" href="{{ url('laporan/kecamatan') }}">Tingkat Kecamatan</a>
                <a class="collapse-item" href="{{ url('laporan/kabupaten') }}">Tingkat Kabupaten</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
