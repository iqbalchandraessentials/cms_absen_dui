<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.head')
    @stack('css')
</head>
<body>
    <!-- Navigation Bar-->
    @include('layouts.nav')
    <!-- End Navigation Bar-->

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="wrapper">
        <div class="container-fluid">
            @yield('breadcrumb')
            @yield('content')
        </div> <!-- end container-fluid -->
    </div>
    <!-- end wrapper -->

    <!-- ============================================================== -->
    <!-- End Page content -->
    @include('layouts.footer')
    @stack('js')
    <!-- ============================================================== -->
</body>

</html>
