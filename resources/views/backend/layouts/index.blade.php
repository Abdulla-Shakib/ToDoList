<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}" /> --}}
    <title>@yield('title')</title>
    @include('backend.layouts.partial.css')
    @stack('style')
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        @include('backend.layouts.partial.topBar')
        @include('backend.layouts.partial.sideBar')
        <!-- Content Wrapper. Contains page content -->

        <div class="content-wrapper">
            @yield('content')
        </div>
        <!-- /.content-wrapper -->

        @include('backend.layouts.partial.footer')
    </div>
    <!-- ./wrapper -->
    @include('backend.layouts.partial.js')
    @stack('script')
</body>

</html>
