<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="/" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{url('assets/images/logo/Seser_APP.png')}}" alt="" height="24">
                    </span>
                    <span class="logo-lg">
                        <img src="{{url('assets/images/logo/Seser_logo_horizontal_purple.png')}}" alt="" height="24"> 
                    </span>
                </a>

                <a href="/" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{url('assets/images/logo/Seser_APP.png')}}" alt="" height="24">
                    </span>
                    <span class="logo-lg">
                        <img src="{{url('assets/images/logo/Seser_logo_horizontal_purple.png')}}" alt="" height="24"> 
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

           
        </div>

        <div class="d-flex">

            <div class="dropdown d-none d-sm-inline-block">
                <button type="button" class="btn header-item" id="mode-setting-btn">
                    <i data-feather="moon" class="icon-lg layout-mode-dark"></i>
                    <i data-feather="sun" class="icon-lg layout-mode-light"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item bg-light-subtle border-start border-end" id="page-header-user-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{url('assets/images/users/avatar-1.jpg')}}"
                        alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1 fw-medium"><?php //echo $language["Shawn_L"]; ?>.</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="{{route('profile')}}"><i class="mdi mdi mdi-face-man font-size-16 align-middle me-1"></i>Profile</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{route('logout')}}"><i class="mdi mdi-logout font-size-16 align-middle me-1"></i> Logout</a>
                </div>
            </div>

        </div>
    </div>
</header>

