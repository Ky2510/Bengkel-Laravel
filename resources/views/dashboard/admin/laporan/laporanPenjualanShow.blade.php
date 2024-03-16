@extends('layouts.index')

@section('menuNavbar')
  @include('layouts.components.menuNavbar')
@endsection

@section('content')
<div class="content-wrapper">
  <div class="content-header">
      <div class="container">
          <div class="row mb-2">
              <div class="col-sm-6">
                  <h1 class="m-0"> {{ $title }} </h1>
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
    <div class="card">
        <div class="card-body p-2 ">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 10px">No</th>
                        <th>Nama </th>
                        <th>Jenis Motor</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reportKeranjang as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->keranjang->barang->nama }}</td>
                        {{-- <td>{{ $item->keranjang->pembelian->jenis }}</td> --}}
                        {{-- <td>Rp.{{ $item->keranjang->pembelian->hargaJual }}</td> --}}
                        {{-- <td>{{ $item->keranjang->pembelian->stok }} ({{ $item->keranjang->satuan->nama }})</td> --}}
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    })
</script>
@endsection