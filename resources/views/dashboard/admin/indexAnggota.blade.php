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
                                    <input class="form-control form-control-navbar" name="search" value="{{ request('search') }}" type="search" placeholder="Cari nama anggota..." aria-label="Search">
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
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="font-family: 'Alice', serif; color:#272829; width: 10px">No</th>
                                        <th style="font-family: 'Alice', serif; color:#272829">Nama</th>
                                        <th style="font-family: 'Alice', serif; color:#272829">Jenis Kelamin</th>
                                        <th style="font-family: 'Alice', serif; color:#272829">Tempat/Tanggal Lahir</th>
                                        <th style="font-family: 'Alice', serif; color:#272829">Alamat</th>
                                        <th style="font-family: 'Alice', serif; color:#272829">No HP</th>
                                        <th style="font-family: 'Alice', serif; color:#272829">Akun</th>
                                        <th style="font-family: 'Alice', serif; color:#272829; width: 40px">Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($models as $item)
                                        @if ($item->user->akses == 'admin')
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $item->jeniskelamin }}</td>
                                                <td>{{ $item->tpt_lhr }}, {{ $item->tgl_lhr }}</td>
                                                <td>{{ $item->alamat }}</td>
                                                <td>{{ $item->no_hp }}</td>
                                                <td><a href="{{ route($routePrefix . '.ubah-akun', $item->user->id) }}">{{ $item->user->email }}</a></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route($routePrefix . '.ubah', $item->id) }}" class="btn btn-warning btn-md btn-sm d-inline-block mr-1"><i class="fa-solid fa-pen-to-square"></i></a>
                                                        <a href="{{ route($routePrefix . '.destroy', $item->id) }}" class="btn btn-danger btn-md btn-sm d-inline-block"><i class="fa-solid fa-trash"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="float-right">
                                {{ $models->links() }}
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