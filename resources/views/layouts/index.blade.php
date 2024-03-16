<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="cache-control" content="no-cache, no-store, must-revalidate">
  <meta http-equiv="pragma" content="no-cache">
  <meta http-equiv="expires" content="0">
  <title>Bengkel Mandiri Jaya Motor | {{ $title }}</title>
  <style>
        body {
            background-image: url('images/background.jpg'); 
            background-size: cover;
            background-repeat: no-repeat;
        }
  </style>
  {{-- Font Awesome --}}
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Play:wght@700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

  {{-- animate css --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('template') }}/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('template') }}/dist/css/adminlte.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('template') }}/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="{{ asset('template') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  @vite(['resources/css/app.css'])
</head>
<body class="hold-transition layout-top-nav">
  <div class="wrapper">
    <nav class="main-header navbar navbar-expand-md" style="background: linear-gradient(to right, #A8A196, #7D7463), linear-gradient(to bottom, #053B50, #64CCC5);">
      <div class="container">
          <a href="" class="navbar-brand">
            <span class="brand-text font-weight-light" style="color: #EEEEEE;  font-family: 'Play', sans-serif;">Bengkel Mandiri Jaya Motor</span>
          </a>
          <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
          <!-- Left navbar links -->
          <ul class="navbar-nav ml-auto">
            @yield('menuNavbar')
          </ul>
        </div>
      </div>
    </nav>
    @yield('content')
    <aside class="control-sidebar control-sidebar-dark">
    </aside>
  </div>
  <script src="{{ asset('template') }}/plugins/jquery/jquery.min.js"></script>
  <script src="{{ asset('template') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('template') }}/dist/js/adminlte.min.js"></script>
  <script src="{{ asset('template') }}/plugins/select2/js/select2.full.min.js"></script>
  @vite(['resources/js/app.js'])
</body>
</html>
