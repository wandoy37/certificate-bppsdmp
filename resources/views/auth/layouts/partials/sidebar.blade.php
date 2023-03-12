<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <img src="{{ asset('atlantis') }}/img/profile.jpg" alt="..." class="avatar-img rounded-circle">
                </div>
                <div class="info text-capitalize">
                    <a data-toggle="collapse" href="#" aria-expanded="true">
                        <span>
                            {{ Auth::user()->name }}
                            <span class="user-level"><i class="fas fa-circle text-success"></i>
                                Online
                            </span>
                        </span>
                    </a>
                </div>
            </div>
            <ul class="nav nav-success">
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">MENU MASTER</h4>
                </li>
                <li class="nav-item {{ request()->segment(2) == 'pengguna' ? 'active' : '' }}">
                    <a href="{{ route('dashboard.user.index') }}">
                        <i class="fas fa-users-cog"></i>
                        <p>Pengguna</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">MENU NAVIGATIONS</h4>
                </li>
                <li class="nav-item {{ request()->segment(2) == 'dashboard' ? 'active' : '' }}">
                    <a href="{{ route('dashboard.index') }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->segment(2) == 'peserta' ? 'active' : '' }}">
                    <a href="{{ route('dashboard.participant.index') }}">
                        <i class="fas fa-users"></i>
                        <p>Peserta</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->segment(2) == 'penandatangan' ? 'active' : '' }}">
                    <a href="{{ route('dashboard.penandatangan.index') }}">
                        <i class="fas fa-user-check"></i>
                        <p>Penandatangan</p>
                    </a>
                </li>
                <li class="nav-section">
                    <h4 class="text-section">KELOLA SERTIFIKAT</h4>
                </li>
                <li class="nav-item {{ request()->segment(2) == 'category' ? 'active' : '' }}">
                    <a href="{{ route('dashboard.category.index') }}">
                        <i class="fas fa-box"></i>
                        <p>Category</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->segment(2) == 'pelatihan' ? 'active' : '' }}">
                    <a href="{{ route('dashboard.training.index') }}">
                        <i class="fas fa-book-reader"></i>
                        <p>Pelatihan</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->segment(2) == 'sertifikat' ? 'active' : '' }}">
                    <a href="{{ route('dashboard.certificate.index') }}">
                        <i class="fas fa-certificate"></i>
                        <p>Sertifikat</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
