@if (Auth::user() == null)
    <script>
        window.location = "/";
    </script>
@else
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <header id="topnav">
        <!-- Topbar Start -->
        <div class="navbar-custom">
            <div class="container-fluid">
                <ul class="list-unstyled topnav-menu float-right mb-0">

                    <li class="dropdown notification-list">
                        <!-- Mobile menu toggle-->
                        <a class="navbar-toggle nav-link">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                        <!-- End mobile menu toggle-->
                    </li>
                    <li class="dropdown profile">
                        <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            @if (Auth::user()->photo_path)
                                <img src="{{ asset('uploads/profile_images/' . Auth::user()->photo_path) }}" alt="user-image" class="rounded-circle">
                            @else
                                <img src="{{ asset('style/dist/assets/images/users/ic_globe-3.png') }}" alt="user-image" class="rounded-circle">
                            @endif
                            {{ Auth::user()->name }}

                            <span class="d-none d-sm-inline-block ml-1 font-weight-medium"></span>
                            <i class="mdi mdi-chevron-down d-none d-sm-inline-block"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                            <a href="{{ route('logout-admin') }}" class="dropdown-item notify-item">
                                <i class="mdi mdi-logout-variant"></i>
                                <span>Logout</span>
                            </a>
                        </div>
                    </li>
                </ul>

                <!-- LOGO -->
                <div class="logo-box">
                    <a href="{{ route('home') }}" class="logo text-center logo-dark">
                        <span class="logo-lg">
                            <img src="{{ asset('style/dist/assets/images/dieselone-logo.png') }}" alt="" height="40">
                            <!-- <span class="logo-lg-text-dark">Uplon</span> -->
                        </span>
                        <span class="logo-sm">
                            <!-- <span class="logo-lg-text-dark">U</span> -->
                            <img src="{{ asset('style/dist/assets/images/dieselone-logo.png') }}" alt="" height="24">
                        </span>
                    </a>

                    <a href="{{ route('home') }}" class="logo text-center logo-light">
                        <span class="logo-lg">
                            <img src="{{ asset('style/dist/assets/images/dieselone-logo.png') }}" alt="" height="40">
                            <!-- <span class="logo-lg-text-dark">Uplon</span> -->
                        </span>
                        <span class="logo-sm">
                            <!-- <span class="logo-lg-text-dark">U</span> -->
                            <img src="{{ asset('style/dist/assets/images/icon.png') }}" alt="" height="24">
                        </span>
                    </a>
                </div>
            </div> <!-- end container-fluid-->
        </div>
        <!-- end Topbar -->

        <div class="topbar-menu">
            <div class="container-fluid">
                <div id="navigation">
                    <!-- Navigation Menu-->
                    <ul class="navigation-menu">

                        <li class="has-submenu">
                            <a href="{{ route('home') }}">
                                <i class="mdi mdi-view-dashboard"></i>Dashboard
                            </a>
                        </li>

                        <li class="has-submenu">
                            <a href="#">
                                <i class="mdi mdi-database"></i>Master Data <div class="arrow-down"></div>
                            </a>
                            <ul class="submenu megamenu">
                                <li>
                                    <ul>
                                        @can('view-employee', Auth::user())
                                            <li><a href="{{ route('employee.index') }}">Employee</a></li>
                                        @endcan
                                        @can('view-internal-memo', Auth::user())
                                            <li><a href="{{ route('internal_memo.index') }}">Internal Memo</a></li>
                                        @endcan
                                        @can('view-location', Auth::user())
                                            <li><a href="{{ route('location.index') }}">Location</a></li>
                                        @endcan
                                        @can('view-schedule', Auth::user())
                                            <li><a href="{{ route('schedule.index') }}">Schedule</a></li>
                                        @endcan
                                        @can('view-businessunit', Auth::user())
                                            <li><a href="{{ route('organization.index') }}">Organization</a></li>
                                        @endcan
                                        @can('view-department', Auth::user())
                                            <li><a href="{{ route('department.index') }}">Department</a></li>
                                        @endcan
                                        @can('view-division', Auth::user())
                                            <li><a href="{{ route('division.index') }}">Division</a></li>
                                        @endcan
                                        @can('view-level', Auth::user())
                                            <li><a href="{{ route('position.index') }}">Level</a></li>
                                        @endcan
                                        @can('view-jobposition', Auth::user())
                                            <li><a href="{{ route('job-position.index') }}">Job Position</a></li>
                                        @endcan
                                        @can('view-roster', Auth::user())
                                            <li><a href="/roster">Roster DUM</a></li>
                                        @endcan
                                        @can('view-timeoff', Auth::user())
                                            <li><a href="{{ route('setting_time_off.index') }}">Time Off</a></li>
                                        @endcan
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="has-submenu">
                            <a href="#"> <i class="mdi mdi-file-multiple-outline"></i>Report <div class="arrow-down">
                                </div></a>
                            <ul class="submenu">
                                @can('view-reportabsence', Auth::user())
                                    <li><a href="{{ route('report_absence.index') }}">Absence</a></li>
                                @endcan
                                @can('view-overtime', Auth::user())
                                    <li><a href="{{ route('overtime.index') }}">Overtime</a></li>
                                @endcan
                                @can('view-reporttimeoff', Auth::user())
                                    <li><a href="{{ route('time_off.index') }}">Time Off</a></li>
                                @endcan
                                @can('view-outofrange', Auth::user())
                                    <li><a href="{{ route('outofrange.index') }}">Out Of Range</a></li>
                                @endcan
                                @can('view-attendance', Auth::user())
                                    <li><a href="{{ route('attendance.index') }}">Attendances</a></li>
                                @endcan
                            </ul>
                        </li>
                        @can('hak-akses', Auth::user())
                            <li class="has-submenu">
                                <a href="#"> <i class="mdi mdi-settings"></i>Setting <div class="arrow-down">
                                    </div></a>
                                <ul class="submenu">
                                    <li><a href="{{ route('permission.index') }}">Permission</a></li>
                                    <li><a href="{{ route('role.index') }}">Roles</a></li>
                                </ul>
                            </li>
                        @endcan
                        @can('approval-ga', Auth::user())
                            <li class="has-submenu">
                                <a href="#"> <i class="mdi mdi-xing-box"></i>GA <div class="arrow-down">
                                    </div></a>
                                <ul class="submenu">
                                    <li><a href="{{ route('borrow-vehicles.create') }}">Borrow</a></li>
                                    <li><a href="{{ route('pinjammobil.create') }}">Vehicle</a></li>
                                    <li><a href="{{ route('location-vehicles.index') }}">Location</a></li>
                                    <li><a href="{{ route('pic-vehicles.index') }}">PIC</a></li>
                                    <li><a href="{{ route('drivers.index') }}">Driver</a></li>
                                </ul>
                            </li>
                        @endcan
                        <li class="has-submenu" id="log-out">
                            <a href="{{ route('logout') }}" class="dropdown-item notify-item">
                                <i class="mdi mdi-logout-variant"></i>
                                <span>Logout</span>
                            </a>
                        </li>
                    </ul>
                    <!-- End navigation menu -->

                    <div class="clearfix"></div>
                </div>
                <!-- end #navigation -->
            </div>
            <!-- end container -->
        </div>
        <!-- end navbar-custom -->
    </header>
@endif
