@extends('layouts.index', ['title' => 'Judul Default'])

@section('menuNavbar')
    @include('customer.components.menuNavbar')
@endsection

@section('content')
<section class="content">
    <div class="row">
        <div class="container">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="row mt-4">
                    <div class="container">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header text-center"  style="background-color: #A59E92;">
                                    <h1 class="m-0"><span style="font-family: 'Play', sans-serif; color:#272829"> Register </span></h1>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="input-group mb-3">
                                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" placeholder="Username">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                    <span class="fas fa-user"></span>
                                                    </div>
                                                </div>
                                                @error('username')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="input-group mb-3">
                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email">
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
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Passwod">
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
                                            <div class="input-group mb-3">
                                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Konfirmasi Password">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                    <span class="fas fa-lock"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="input-group mb-3">
                                                <input id="namaPertama" type="text" class="form-control @error('namaPertama') is-invalid @enderror" name="namaPertama" value="{{ old('namaPertama') }}" placeholder="Nama pertama">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                    <span class="fas fa-user"></span>
                                                    </div>
                                                </div>
                                                @error('namaPertama')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="input-group mb-3">
                                                <input id="namaTerakhir" type="namaTerakhir" class="form-control @error('namaTerakhir') is-invalid @enderror" name="namaTerakhir" value="{{ old('namaTerakhir') }}" placeholder="Nama terakhir">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-user"></span>
                                                    </div>
                                                </div>
                                                @error('namaTerakhir')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="input-group mb-3">
                                                <input id="no_hp" type="no_hp" class="form-control @error('no_hp') is-invalid @enderror" name="no_hp" value="{{ old('no_hp') }}" placeholder="No. HP/Whatsapp">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-phone"></span>
                                                    </div>
                                                </div>
                                                @error('no_hp')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="input-group mb-3">
                                                <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" cols="40" rows="3" placeholder="Alamat">{{ old('alamat') }}</textarea>
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-map-marker"></span>
                                                    </div>
                                                </div>
                                                @error('alamat')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <button type="submit" class="btn btn-primary float-right">Register</button>
                                            <a href="{{ route('login') }}"  class="btn btn-success mx-2 float-right">Login</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- /.register-box -->

<!-- jQuery -->
<script src="{{ asset('template') }}/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('template') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="{{ asset('template') }}/dist/js/adminlte.min.js"></script>
@endsection
