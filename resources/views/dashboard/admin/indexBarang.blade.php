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
                    <div class="card-header"  style="background-color: #A59E92;">
                        <h3 class="card-title"><span style="font-family: 'Alice', serif; color:#272829">{{ $miniTitle }}</span></h3>
                        <div class="card-tools">
                            {!! Form::open(['route' => $routePrefix. '.index', 'method' => 'GET' ]) !!}
                                <div class="input-group input-group-sm">
                                    <input class="form-control form-control-navbar" name="search" value="{{ request('search') }}" type="search" placeholder="Cari kode/nama barang..." aria-label="Search">
                                    <div class="input-group-append">
                                        <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
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
                                        <th style="font-family: 'Alice', serif; color:#272829;">Kode</th>
                                        <th style="font-family: 'Alice', serif; color:#272829;">Nama</th>
                                        <th style="font-family: 'Alice', serif; color:#272829;">Kategori</th>
                                        <th style="font-family: 'Alice', serif; color:#272829;">Merek</th>
                                        <th style="font-family: 'Alice', serif; color:#272829;">Gambar</th>
                                        <th style="font-family: 'Alice', serif; color:#272829;">Stok</th>
                                        <th style="font-family: 'Alice', serif; color:#272829;">Satuan</th>
                                        <th style="font-family: 'Alice', serif; color:#272829;">Harga</th>
                                        <th style="font-family: 'Alice', serif; color:#272829; width: 40px">Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($models as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->kode }}</td>
                                        <td>{{ $item->pembelian->nama }}</td>
                                        <td>{{ $item->kategori->nama }}</td>
                                        <td>{{ $item->merek->nama }}</td>
                                        <td> <img src="{{ \Storage::url($item->image ) }}" width="110"></td>
                                        <td>{{ $item->pembelian->stok }}</td>
                                        <td>{{ $item->satuan->nama }}</td>
                                        <td>Rp.{{ $item->pembelian->hargaJual }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('barang.edit', $item->id) }}" class="btn btn-warning btn-md btn-sm d-inline-block mr-1"><i class="fa-solid fa-pen-to-square"></i></a>
                                                <a href="{{ route('barang.destroy', $item->id) }}" class="btn btn-danger btn-md btn-sm d-inline-block"><i class="fa-solid fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
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