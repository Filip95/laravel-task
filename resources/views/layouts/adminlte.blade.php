<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <title>@yield('title','AdminLTE')</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/bootstrap/css/bootstrap.min.css') }}">
  <!-- FontAwesome -->
  <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/font-awesome/css/font-awesome.min.css') }}">
  <!-- AdminLTE core -->
  <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/AdminLTE.min.css') }}">
  <!-- Skin -->
  <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/skins/skin-blue.min.css') }}">

  <!-- Vite (other app CSS) -->
  @vite('resources/css/app.css')
</head>
<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">
      <a href="#" class="logo"><b>Admin</b>LTE</a>
      <nav class="navbar navbar-static-top"></nav>
    </header>

    <!-- Sidebar -->
    <aside class="main-sidebar">
      <section class="sidebar">
        <ul class="sidebar-menu">
          <li class="header">HEADER</li>
          <li class="active">
            <a href="#"><i class="fa fa-link"></i> <span>Dashboard</span></a>
          </li>
        </ul>
      </section>
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
      @yield('content')
    </div>

  </div>

  <!-- jQuery -->
  <script src="{{ asset('vendor/adminlte/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
  <!-- Bootstrap JS -->
  <script src="{{ asset('vendor/adminlte/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('vendor/adminlte/dist/js/app.min.js') }}"></script>

  <!-- Vite (your other app JS) -->
  @vite('resources/js/app.js')
</body>
</html>
