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
                      <h1 class="m-0">
                          <span style="font-family: 'Play', sans-serif; color:#272829">{{ $title }} 
                              @if (Request()->input('nama') == null)
                                  Masuk
                              @else
                                  {{ Request()->input('nama') }}
                              @endif
                          </span>
                      </h1>
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
        <h6 class="text-center display-4"><span style="font-family: 'Play', sans-serif; color:#272829">
            @if (Request()->input('tgl') != null)
                {{ \Carbon\Carbon::parse(Request()->input('tgl'))->isoFormat('D MMMM YYYY') }}</span>
            @elseif (Request()->input('nama') == null)
                {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}

            @endif
        </h6>
          <div class="container">
              <div class="card mt-4">
                  <div class="card-body p-2 ">
                      <table class="table table-bordered">
                          <thead>
                              <tr>
                                  <th style="width: 10px">No</th>
                                  <th>Nama </th>
                                  <th>Jenis Motor</th>
                                  <th>Harga Beli</th>
                                  <th>Harga Jual</th>
                                  <th>Stok </th>
                                  <th>Suplayer</th>
                                  <th>Tanggal</th>
                              </tr>
                          </thead>
                          <tbody>
                            @if (request()->input('nama') && request()->input('tgl') == null)
                                @foreach ($barangMasukToday as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->jenis }}</td>
                                    <td>Rp.{{ $item->hargaBeli }}</td>
                                    <td>Rp.{{ $item->hargaJual }}</td>
                                    <td>{{ $item->stok }}</td>
                                    <td>{{ $item->suplay->nama }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->isoFormat('D MMMM YYYY') }}</td>
                                </tr>
                                @endforeach
                            @endif
                            @foreach ($reportBarangMasuk as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->jenis }}</td>
                                    <td>Rp.{{ $item->hargaBeli }}</td>
                                    <td>Rp.{{ $item->hargaJual }}</td>
                                    <td>{{ $item->stok }}</td>
                                    <td>{{ $item->suplay->nama }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->isoFormat('D MMMM YYYY') }}</td>
                                </tr>
                            @endforeach
                          </tbody>
                      </table>
                        <style>
                            .btn-kembali {
                                background-color: #D8D9DA;
                                color: #272829;
                                border: none; /* Menghilangkan border */
                                cursor: pointer;
                            }
                            .btn-kembali:hover{
                                background-color: #61677A;
                                color: #FFFFFF;
                                border: none; /* Menghilangkan border */
                                cursor: pointer;
                            }
                        </style>
                        <a href="{{ route('laporan-barangmasuk.index') }}" class="btn-kembali btn btn-md btn-round float-right mt-2">Kembali</a>
                  </div>
              </div>
          </div>
        </div>
    </div>
</section>
@include('customer.components.footer')

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