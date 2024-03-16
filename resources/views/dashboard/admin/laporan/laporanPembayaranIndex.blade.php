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
      <h6 class="text-center display-4"><span style="font-family: 'Play', sans-serif; color:#272829">Pembayaran</span></h6>
      <form action="{{ route('laporan-pembayaran.show') }}" method="GET">
        <div class="row mt-5">
          <div class="col-md-10 offset-md-1">
            <div class="card">
              <div class="card-body">
                <ul>
                  <li><span class="text-danger">Apabila form tidak diisi dan tekan <b>Filter</b> maka <i>Data yang "tampil adalah hari ini"</i></span></li>
                </ul>
                <div class="row">
                  <div class="col-6">
                    <div class="form-group">
                      {!! Form::label('atas_nama', 'Atas Nama', ['style' => 'font-family: Alice, serif; color:#272829']) !!}
                      {!! Form::text('atas_nama', old('atas_nama'), ['class' => 'form-control form-control form-control-md ' . ($errors->first('nama_rekening') ? 'is-invalid' : ''), 'placeholder' => "Masukan atas nama..."]) !!}
                      <span class="text-danger">{{ $errors->first('atas_nama') }}</span>
                    </div>
                    </div>
                    <div class="col-3">
                      <div class="form-group">
                        {!! Form::label('bank', 'Nama Bank via transfer', ['style' => 'font-family: Alice, serif; color:#272829']) !!}
                        {!! Form::select('bank', $listBank, old('bank'), ['class' => 'form-control form-control-md select2bs4 ' . ($errors->first('bank') ? 'is-invalid' : ''), 'placeholder' => 'Pilih Bank']) !!}
                        <span class="text-danger">{{ $errors->first('bank') }}</span>
                      </div>
                    </div>
                    <div class="col-3">
                      <div class="form-group">
                        {!! Form::label('tgl_pembayaran', 'Tanggal Pembayaran', ['style' => 'font-family: Alice, serif; color:#272829']) !!}
                        {!! Form::date('tgl_pembayaran', old('tgl_pembayaran'), ['class' => 'form-control form-control form-control-md ' . ($errors->first('tgl_pembayaran') ? 'is-invalid' : ''), 'placeholder' => 'Pilih Bank']) !!}
                        <span class="text-danger">{{ $errors->first('tgl_pembayaran') }}</span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group input-group-lg">
                      <input type="text" name="id_transaksi" style="font-family: Alice, serif; color:#272829" class="form-control form-control-lg" placeholder="Masukan ID Transaksi..." value="">
                      <div class="input-group-append">
                        <style>
                          .btn-cari {
                              background-color: #91C8E4;
                              color: #272829;
                              border: none; /* Menghilangkan border */
                              cursor: pointer;
                          }
                          .btn-cari:hover{
                              background-color: #4F709C;
                              color: #FFFFFF;
                              border: none; /* Menghilangkan border */
                              cursor: pointer;
                          }
                        </style>
                        <button type="submit" class="btn-cari btn btn-lg">
                            <i class="fa fa-search"></i>  Filter
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <div>
      </form>
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