<!-- ========== Left Sidebar Start ========== -->
<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li>
                    <a href="/">
                        <i data-feather="home"></i>
                        <span data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('newappointment')}}">
                        <i data-feather="users"></i>
                        <span>Appointment</span>
                    </a>
                </li>
                @if(Auth::user()->type == 'admin')
                <li>
                    <a href="{{route('department')}}">
                        <i data-feather="layout"></i>
                        <span>Departments</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('staff')}}">
                        <i class="mdi mdi-account-supervisor"></i>
                        <span>Staff</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('setting')}}">
                        <i data-feather="settings" class="icon-lg"></i>
                        <span>Setting</span>
                    </a>
                </li>
                @endif
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
