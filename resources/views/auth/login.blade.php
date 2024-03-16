@extends('layouts.index', ['title' => 'Judul Default'])

@section('menuNavbar')
    @include('customer.components.menuNavbar')
@endsection

@section('content')
<section class="content">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header text-center"  style="background-color: #A59E92;">
                        <h1 class="m-0"><span style="font-family: 'Play', sans-serif; color:#272829"> Login </span></h1>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                            <script>
                                setTimeout(function() {
                                    $('.alert').fadeOut('slow');
                                }, 5000);
                            </script>
                        @elseif(session('warning'))
                            <div class="alert alert-warning">
                                {{ session('warning') }}
                            </div>
                            <script>
                                setTimeout(function() {
                                    $('.alert').fadeOut('slow');
                                }, 5000);
                            </script>
                        @elseif(session('danger'))
                            <div class="alert alert-danger">
                                {{ session('danger') }}
                            </div>
                            <script>
                                setTimeout(function() {
                                    $('.alert').fadeOut('slow');
                                }, 5000);
                            </script>
                        @endif
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="input-group mb-3">
                                {{-- Email --}}
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email" >
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-group mb-3">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" >
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-8">
                                </div>
                                <div class="col-4">
                                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                                </div>
                            </div>
                        </form>
                        <p class="mb-0">
                            <a href="{{ route('register') }}" class="text-center">Register</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

<!-- jQuery -->
<script src="{{ asset('template') }}/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('template') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="{{ asset('template') }}/dist/js/adminlte.min.js"></script>
</body>
</html>

