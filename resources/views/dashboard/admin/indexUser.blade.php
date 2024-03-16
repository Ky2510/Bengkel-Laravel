@extends('layouts.index')

@section('menuNavbar')
  @include('layouts.components.menuNavbar')
@endsection

@section('content')
<section class="content">
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><span style="font-family: 'Play', sans-serif; color:#272829">{{ $title }} </span></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            @foreach ($breadcrumbs as $breadcrumb)
                                <li class="breadcrumb-item">
                                    <a href="{{ route($breadcrumb['route']) }}">
                                        <span style="{{ \Route::currentRouteName() == $breadcrumb['route'] ? 'color: black; font-family: Alice, serif; color:#A59E92;' : 'color:#272829;' }}">
                                            {{ $breadcrumb['label'] }}
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container">
                <div class="card">
                    <div class="card-header" style="background-color: #A59E92;">
                        <h3 class="card-title"><span style="font-family: 'Alice', serif; color:#272829">{{ $miniTitle }}</span></h3>
                        <div class="card-tools">
                            {!! Form::open(['route' => $routePrefix. '.index', 'method' => 'GET' ]) !!}
                                <div class="input-group input-group-sm">
                                    <input class="form-control form-control-navbar" name="search" value="{{ request('search') }}" type="search" placeholder="Cari nama user..." aria-label="Search">
                                    <div class="input-group-append">
                                        <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                       <!-- SEARCH FORM -->
                    <div class="card-body p-2 ">
                        <div class="container">
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                                <script>
                                    setTimeout(function() {
                                        $('.alert').fadeOut('slow');
                                    }, 3000);
                                </script>
                            @elseif(session('warning'))
                                <div class="alert alert-warning">
                                    {{ session('warning') }}
                                </div>
                                <script>
                                    setTimeout(function() {
                                        $('.alert').fadeOut('slow');
                                    }, 3000);
                                </script>
                            @elseif(session('danger'))
                                <div class="alert alert-danger">
                                    {{ session('danger') }}
                                </div>
                                <script>
                                    setTimeout(function() {
                                        $('.alert').fadeOut('slow');
                                    }, 3000);
                                </script>
                            @endif
                            <div class="row">
                                @foreach ($models as $item)
                                    <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                                        <div class="card bg-light d-flex flex-fill">
                                            <div class="card-header text-muted border-bottom-0">
                                                {{ $item->user->akses }}
                                            </div>
                                            <div class="card-body pt-0">
                                                <div class="row">
                                                    <div class="col-7">
                                                    <h2 class="lead"><b>{{ $item->namaPertama }} {{ $item->namaTerakhir }}</b></h2>
                                                    <p class="text-muted text-sm"><b>Email: </b>{{ $item->user->email }} <b>Username: </b>{{ $item->user->username }}</p>
                                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Address: {{ $item->alamat }}</li>
                                                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone {{ $item->no_hp }}</li>
                                                    </ul>
                                                    </div>
                                                    <div class="col-5 text-center">
                                                    <img src="{{ asset('images/userbg-2.png') }}" alt="user-avatar" class="img-circle img-fluid">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <div class="text-right">
                                                    <a href="{{ route('user.status-update', [
                                                            'model' => 'user',
                                                            'id' => $item->id_user,
                                                            'status' => $item->user->status ==  'aktif' ? 'non-aktif' : 'aktif',
                                                        ]) }}" class="btn btn-sm  {{ $item->user->status == 'aktif' ? 'btn-danger' : 'btn-success'}}">
                                                        <i class="fas fa-user"></i> {{ $item->user->status == 'aktif' ? 'Non-Aktifkan' : 'Aktifkan' }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </div>
</section>
@include('customer.components.footer')
@endsection