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
      <h6 class="text-center display-4"><span style="font-family: 'Play', sans-serif; color:#272829">Barang Masuk</span></h6>
      <form action="{{ route('laporan-barangmasuk.show') }}" method="GET">
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
                      {!! Form::label('nama', 'Nama Barang', ['style' => 'font-family: Alice, serif; color:#272829']) !!}
                      {!! Form::text('nama', old('nama'), ['class' => 'form-control form-control form-control-md ' . ($errors->first('nama_rekening') ? 'is-invalid' : ''), 'placeholder' => "Masukan nama barang..."]) !!}
                      <span class="text-danger">{{ $errors->first('nama') }}</span>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      {!! Form::label('tgl', 'Tanggal Barang Masuk', ['style' => 'font-family: Alice, serif; color:#272829']) !!}
                      {!! Form::date('tgl', old('tgl'), ['class' => 'form-control form-control form-control-md ' . ($errors->first('tgl') ? 'is-invalid' : ''), 'placeholder' => 'Pilih Bank']) !!}
                      <span class="text-danger">{{ $errors->first('tgl') }}</span>
                      <div class="input-group-append float-right">
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
                        <button type="submit" class="btn-cari btn mt-1 btn-md">
                            <i class="fa fa-search"></i>  Filter
                        </button>
                      </div>
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