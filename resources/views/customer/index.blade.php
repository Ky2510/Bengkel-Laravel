@extends('layouts.index')

@section('menuNavbar')
  @include('customer.components.menuNavbar')
@endsection

@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Alice&family=Pacifico&family=Play:wght@700&display=swap" rel="stylesheet">
<style>
  .input-quantity {
    display: flex;
    align-items: center;
  }

  .btn-quantity {
    padding: 5px 10px;
    border: none;
    background-color: #f0f0f0;
    cursor: pointer;
  }
  .price {
    float: right;
  }
</style>
<section class="content">
  <div class="card">
    <div class="card-body" style="background-color: #f0f0f0">
      <div class="row mt-1">
        <div class="col-md-8 offset-md-2">
            <form action="{{ route('customer.produk') }}" method="GET">
                <div class="input-group">
                    <input type="search" class="form-control form-control-md"  name="search" value="{{ Request()->input('search') }}"  placeholder="Dapatkan barang disini...">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-md btn-default">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-sm-8 mt-2">
          <img class="img-fluid" src="{{ asset('images/image1.jpg') }}" alt="Photo">
        </div>
        <div class="col-sm-4 mt-2">
          <div class="row">
            <div class="col-sm-12">
              <img class="img-fluid mb-3" src="{{ asset('images/image2.jpg') }}" alt="Photo">
              <img class="img-fluid mb-3" src="{{ asset('images/image3.jpg') }}" alt="Photo">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div>
        <h2 class="text-center"><span style="font-family: 'Alice', sans-serif; color:#f0f0f0;  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">Kami siap membantu Anda menemukan perlengkapan motor yang Anda inginkan</span></h2>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col-lg-8">
        <h2 class="text-center"><span style="font-family: 'Play', sans-serif; color:#f0f0f0; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">Barang Terbaru</span></h2> 
        <div class="card">
          <div class="card-body" style="background-color: #f0f0f0">
            <div class="container">
              <div class="row mt-3">
                @foreach ($produk as $item)
                  <div class="col-lg-3">
                    <div class="card animate__animated animate__fadeInLeft">
                      <div class="card-header" style="background-color: #A59E92;">
                        <div class="float-right">
                          <h5 class="card-title m-0" style="font-family: 'Play', sans-serif; color:#272829">{{ $item->kategori->nama }}</h5>
                        </div>
                      </div>
                      <div class="card-body" style="background-color: #FEFBF6">
                        <h6><span style="font-family: 'Alice', serif; color:#272829"><center>{{ $item->pembelian->nama }} ({{ $item->merek->nama }}) - {{ $item->pembelian->jenis }}</center></span></h6>
                        <div class="position-relative">
                          <img src="{{ \Storage::url($item->image ) }}" alt="{{ $item->pembelian->nama }}" class="img-fluid">
                          <div class="ribbon-wrapper ribbon-lg">
                            <div class="ribbon text-sm" style="background-color:#272829; color:#FEFBF6">
                              Rp.{{ $item->pembelian->hargaJual }}
                            </div>
                          </div>
                        </div>
                        <p class="card-text">
                        @if ($item->pembelian)
                            @if ($item->pembelian->stok == 0)
                              <span style="font-family: 'Alice', serif; color:#272829">Stok Habis</span>
                            @else
                              <span style="font-family: 'Alice', serif; color:#272829">tersisa {{ $item->pembelian->stok }} {{ $item->satuan->nama }} </span>
                            @endif
                        @endif
                        </p>
                        {!! Form::model($model, ['route' => $route,'method' => $method, 'files' => true]) !!}
                        <input type="hidden" name="id_barang" value="{{ $item->id }}" id="">
                        <div class="row justify-content-center">
                          <div class="input-quantity">
                            <div class="container">
                              {!! Form::hidden('id_user', auth()->user() ? auth()->user()->id : null, ['class' => 'form-control']) !!}
                              {!! Form::hidden('id_pembelian',  $item->pembelian->id , ['class' => 'form-control ']) !!}
                              {!! Form::hidden('id_kategori',  $item->kategori->id , ['class' => 'form-control ']) !!}
                              {!! Form::hidden('id_merek',  $item->merek->id , ['class' => 'form-control ']) !!}
                              {!! Form::hidden('id_satuan',  $item->satuan->id , ['class' => 'form-control ']) !!}
                              <div class="row">
                                <div class="col-lg-9">
                                  <input type="number" name="quantity" id="quantity" min="1" step="1" class="form-control{{ $errors->has('quantity') && $item->id == old('id_barang') ? ' is-invalid' : '' }}" placeholder="Masukan jumlah ..." value="{{ $errors->has('quantity') && $item->id == old('barang') ? old('quantity') : '' }}">
                                  @if ($errors->has('quantity') && $item->id == old('id_barang'))
                                    <span class="text-danger">{{ $errors->first('quantity') }}</span>
                                  @endif
                                </div>
                                <div class="col-lg-3">
                                  <style>
                                    .cart-button {
                                        color: #A59E92;
                                        border: none; /* Menghilangkan border */
                                        cursor: pointer;
                                      }
                                      .cart-button:hover{
                                        color: #272829;
                                        border: none; /* Menghilangkan border */
                                        cursor: pointer;
                                    }
                                  </style>
                                  <button type="submit" class="cart-button mt-1">
                                    <i class="material-icons">shopping_cart</i>
                                  </button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        {!! Form::close() !!}
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="container">
          <h2 class="text-center"><span style="font-family: 'Play', sans-serif; color:#f0f0f0; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">Kategori</span></h2> 
          <div class="card">
            <div class="card-body" style="background-color: #f0f0f0">
              <div class="row mt-4">
                @foreach ($kategori as $item)
                  <div class="col-lg-6 animate__animated animate__fadeInRight"  id="animated-element">
                    <a href="{{ route('customer.produk', ['search' => $item->nama]) }}">
                      <style>
                        .info-box{
                            font-family: 'Alice', serif;
                            background-color: #A59E92;
                            color: #272829;
                            border: none; /* Menghilangkan border */
                            cursor: pointer;
                          }
                          .info-box:hover{
                            background-color: #272829;
                            color: #A59E92;
                            border: none; /* Menghilangkan border */
                            cursor: pointer;
                        }
                      </style>
                      <div class="info-box">
                        <div class="info-box-content">
                          <span style="font-family: 'Play', sans-serif; color:#272829l">{{ $item->nama }}</span>
                        </div>
                      </div>
                    </a>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
          @auth
            <div class="layanan">
              <style>
                .layananService{
                    font-family: 'Alice', serif;
                    background-color: #EEEEEE;
                    color: #272829;
                    border: none; /* Menghilangkan border */
                    cursor: pointer;
                  }
                  .layananService:hover{
                    background-color: #272829;
                    color: #EEEEEE;
                    border: none; /* Menghilangkan border */
                    cursor: pointer;
                }
              </style>
              @php
                $count = App\Models\LayananService::count();
                $today1 = \Carbon\Carbon::now()->toDateString();
                $allLayanan = App\Models\LayananService::all();
                foreach ($allLayanan as  $value) {
                  $status = $value->status; 
                  $barang = $value->barang;
                }
                $userExists = App\Models\LayananService::where('id_datauser', auth()->user()->id)->exists();
              @endphp
              <button type="submit" class="btn layananService float-left mt-2" data-toggle="modal" data-target="#modal-default">Layanan Service</button>
              {{-- @if ($count !== 0 && $status == 'konfirmasi' && $userID == auth()->user()->id && $barang !== null) --}}
                <button type="submit" class="btn layananService float-left mt-2 mx-2" data-toggle="modal" data-target="#modal-default1">Lihat Selengkapnya</button>
              {{-- @endif --}}
              <div class="modal fade" id="modal-default">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Pendaftaran Layanan Service</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    @if ($count !== 0 && $status == 'belum konfirmasi' && $userID == auth()->user()->id)
                      <table class="table table-hover table-striped">
                        <tbody>
                          @foreach ($allLayanan as $item)
                            @if ($item->id_datauser == $userID && $today1 == $item->created_at->toDateString() && $item->status == 'belum konfirmasi')
                              <tr>
                                <td class="mailbox-name"><a href="read-mail.html">{{ $namaPertama }} {{ $namaTerakhir }}</a></td>
                                <td class="mailbox-subject"><i>{{ $item->nama_motor }} ({{ $item->jenis_motor }})</i></td>
                                <td class="mailbox-subject"><b>{{ $item->id_layanan }}</b> - {{ $item->keluhan }} 
                                </td>
                                <td class="mailbox-attachment">
                                  @if ($item->status == 'belum konfirmasi')
                                    <button class="badge badge-xs badge-info">Menunggu Konfirmasi</button>
                                  @else
                                    <button class="badge badge-xs badge-success">Sudah Konfirmasi</button>
                                  @endif
                                </td>
                                <td class="mailbox-date">{{ $item->created_at->diffForHumans(['locale' => 'id']) }}</td>
                              </tr>
                            @endif
                          @endforeach
                        </tbody>
                      </table>
                    @elseif ($count !== 0 && $status == 'konfirmasi' && $userID == auth()->user()->id)
                      <table class="table table-hover table-striped">
                        <tbody>
                          @if ($barang == 'true')
                            {!! Form::model($model, ['route' => $route,'method' => $method, 'files' => true]) !!}
                              <div class="modal-body" id="modal-default">
                                <div class="form-group">
                                  <input type="hidden" name="id_datauser" value="{{ auth()->user()->id }}">
                                </div>
                                <div class="row">
                                  <div class="col-lg-6">
                                    <div class="form-group">
                                      {!! Form::text('nama_motor', old('nama_motor'), ['class' => 'form-control ' . ($errors->first('nama_motor') ? 'is-invalid' : ''), 'placeholder' => 'Masukkan nama_motor ...']) !!}
                                      <span class="text-danger">{{ $errors->first('nama_motor') }}</span>
                                    </div>
                                  </div>
                                  <div class="col-lg-6">
                                    <div class="form-group">
                                      {!! Form::select('jenis_motor', [
                                        'matic' => 'matic',
                                        'karbu' => 'karbu',
                                        'gigi' => 'gigi',
                                        'kopling' => 'kopling',
                                      ], old('jenis_motor'), ['class' => 'form-control select2bs4 ' . ($errors->first('jenis_motor') ? 'is-invalid' : ''), 'placeholder' => 'Pilih Jenis Motor']) !!}
                                      <span class="text-danger">{{ $errors->first('jenis_motor') }}</span>
                                    </div>
                                  </div>
                                </div>
                                <div class="form-group">
                                  {!! Form::textarea('keluhan', old('keluhan'), ['class' => 'form-control ' . ($errors->first('keluhan') ? 'is-invalid' : ''), 'placeholder' => 'Masukkan keluhan ...', 'rows' => 4]) !!}
                                  <span class="text-danger">{{ $errors->first('keluhan') }}</span>
                                </div>
                              </div>
                              <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <style>
                                  .btn-simpan {
                                      background-color: #82CD47;
                                      color: #272829;
                                      border: none; /* Menghilangkan border */
                                      cursor: pointer;
                                  }
                                  .btn-simpan:hover{
                                      background-color: #379237;
                                      color: #FFFFFF;
                                      border: none; /* Menghilangkan border */
                                      cursor: pointer;
                                  }
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
                                  {!! Form::submit($button , ['class' => 'btn-simpan btn btn-md mx-2  btn-round  float-right']) !!}
                              </div>
                            {!! Form::close() !!}
                          @elseif($barang == null)
                            @foreach ($allLayanan as $item)
                              @if ($item->status == 'konfirmasi' && $item->barang == null)
                                <tr>
                                  <td class="mailbox-name"><a href="read-mail.html">{{ $namaPertama }} {{ $namaTerakhir }}</a></td>
                                  <td class="mailbox-subject"><i>{{ $item->nama_motor }} ({{ $item->jenis_motor }})</i></td>
                                  <td class="mailbox-subject"><b>{{ $item->id_layanan }}</b> - {{ $item->keluhan }}</td>
                                  <td class="mailbox-attachment">
                                    @if ($item->status == 'konfirmasi' && $item->barang == null)
                                      <button class="badge badge-xs badge-info">Menunggu Konfirmasi</button>
                                    @else
                                      <button class="badge badge-xs badge-success">Sudah Konfirmasi</button>
                                    @endif
                                  </td>
                                  <td class="mailbox-date">{{ $item->updated_at->diffForHumans(['locale' => 'id']) }}</td>
                                </tr>
                              @endif
                            @endforeach
                          @endif
                        </tbody>
                      </table>
                    @elseif($count == 0 || !$userExists)
                        {!! Form::model($model, ['route' => $route,'method' => $method, 'files' => true]) !!}
                          <div class="modal-body" id="modal-default">
                            <div class="form-group">
                              <input type="hidden" name="id_datauser" value="{{ auth()->user()->id }}">
                            </div>
                            <div class="row">
                              <div class="col-lg-6">
                                <div class="form-group">
                                  {!! Form::text('nama_motor', old('nama_motor'), ['class' => 'form-control ' . ($errors->first('nama_motor') ? 'is-invalid' : ''), 'placeholder' => 'Masukkan nama_motor ...']) !!}
                                  <span class="text-danger">{{ $errors->first('nama_motor') }}</span>
                                </div>
                              </div>
                              <div class="col-lg-6">
                                <div class="form-group">
                                  {!! Form::select('jenis_motor', [
                                    'matic' => 'matic',
                                    'karbu' => 'karbu',
                                    'gigi' => 'gigi',
                                    'kopling' => 'kopling',
                                  ], old('jenis_motor'), ['class' => 'form-control select2bs4 ' . ($errors->first('jenis_motor') ? 'is-invalid' : ''), 'placeholder' => 'Pilih Jenis Motor']) !!}
                                  <span class="text-danger">{{ $errors->first('jenis_motor') }}</span>
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                              {!! Form::textarea('keluhan', old('keluhan'), ['class' => 'form-control ' . ($errors->first('keluhan') ? 'is-invalid' : ''), 'placeholder' => 'Masukkan keluhan ...', 'rows' => 4]) !!}
                              <span class="text-danger">{{ $errors->first('keluhan') }}</span>
                            </div>
                          </div>
                          <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <style>
                              .btn-simpan {
                                  background-color: #82CD47;
                                  color: #272829;
                                  border: none; /* Menghilangkan border */
                                  cursor: pointer;
                              }
                              .btn-simpan:hover{
                                  background-color: #379237;
                                  color: #FFFFFF;
                                  border: none; /* Menghilangkan border */
                                  cursor: pointer;
                              }
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
                              {!! Form::submit($button , ['class' => 'btn-simpan btn btn-md mx-2  btn-round  float-right']) !!}
                          </div>
                        {!! Form::close() !!}
                    @endif
                  </div>
                </div>
              </div>
              {{-- Layanan --}}
              <div class="modal fade" id="modal-default1">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Layanan Service telah dikonfirmasi</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <table class="table table-hover table-striped">
                        <thead>
                          <tr>
                              <th>No</th>
                              <th>ID Layanan Service</th>
                              <th>Nama Motor</th>
                              <th>Jenis Motor</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($allLayanan as $item)
                            @if ($count !== 0  && $item->id_datauser == auth()->user()->id)
                              @php
                                $dataUser = App\Models\Datauser::where('id_user', $item->id_datauser)->get();
                                $dataAnggota = App\Models\Anggota::where('user_id', $item->id_anggota)->get();
                                $dataBarang = App\Models\ServiceBarang::where('id_layananservice', $item->id)->get();
                              @endphp
                              <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->id_layanan }}</td>
                                <td>{{ $item->nama_motor }}</td>
                                <td>{{ $item->jenis_motor }}</td>
                                @if ($item->barang == null)
                                  <td>
                                    <button class="badge badge-xs badge-info">Menunggu...</button>
                                  </td>
                                @else
                                  <td>
                                      <a href="{{ route('detail.layananservice', $item->id) }}" target="_blank" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                  </td>
                                @endif
                              </tr>
                            @endif
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @endauth
        </div>
      </div>
    </div>
    <div class="row mt-2">
      <div class="container">
        <h2 class="text-center"><span style="font-family: 'Alice', sans-serif; color:#f0f0f0;  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">Selamat Datang di Bengkel Mandiri Jaya Motor</span></h2>
        <div class="card">
          <div class="card-body" style="background-color: #f0f0f0">
            <div class="row mt-4 animate__animated animate__fadeIn animate_delay_2" id="animated-element">
              <div class="col-lg-6">
                <div class="card">
                  <div class="card-header" style="background-color: #A59E92">
                    <h4><span style="font-family: 'Play', sans-serif; color:#272829">Profil</span></h4>
                  </div>
                  <div class="card-body" style="background-color: #FEFBF6">
                    <p style="color: #272829; font-family: 'Alice', serif;"> Mandiri jaya motorberdiri 16 agustus 2016 yg ber alamat di jalan lintas bukittinggi-medan km 6 baringin gadut. nama pemilik DALIL BADRI.bengkel mandiri Jaya motor sendiri merupakan tempat menjual perlengkapan motor dan juga sebagai perbaikan sepeda motor. Alasan pemilik mendirikan karena melihat peluang bisnis dalam jual beli dan perbaikan karena pemilik sendiri merupakan lulusan dalam teknik sepeda motor</p>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header" style="background-color: #A59E92">
                    <h4><span style="font-family: 'Play', sans-serif; color:#272829">Alamat</span></h4>
                  </div>
                  <div class="card-body" style="background-color: #FEFBF6">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3989.7747169427157!2d100.35393447496462!3d-0.26786849972949556!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMMKwMTYnMDQuMyJTIDEwMMKwMjEnMjMuNCJF!5e0!3m2!1sid!2sid!4v1694059411010!5m2!1sid!2sid" width="495" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="card">
                  <div class="card-header" style="background-color: #A59E92">
                    <h4><span style="font-family: 'Play', sans-serif; color:#272829">Tentang</span></h4>
                  </div>
                  <div class="card-body" style="background-color: #FEFBF6">
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="row">
                          <div class="col-lg-4">
                            <p style="color: #272829; font-family: 'Alice', serif;">No Hp/Whatsapp</p>
                          </div>
                          <div class="col-lg-8">
                            <p style="color: #272829; font-family: 'Alice', serif;">+6282215344949</p>
                          </div>
                          <div class="col-lg-4">
                            <p style="color: #272829; font-family: 'Alice', serif;">Alamat</p>
                          </div>
                          <div class="col-lg-8">
                            <p style="color: #272829; font-family: 'Alice', serif;">Jl. Bukittinggi - Padang Sidempuan, Gadut, Kec. Tilatang Kamang, Kabupaten Agam, Sumatera Barat 26123</p>
                          </div>
                          <div class="col-lg-4">
                            <p style="color: #272829; font-family: 'Alice', serif;">Email</p>
                          </div>
                          <div class="col-lg-8">
                            <p style="color: #272829; font-family: 'Alice', serif;"></p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header" style="background-color: #A59E92">
                    <h4><span style="font-family: 'Play', sans-serif; color:#272829">Hubungi Kami</span></h4>
                  </div>
                  <div class="card-body" style="background-color: #FEFBF6">
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="row">
                          <div class="col-lg-2 mt-2">
                            <p style="color: #272829; font-family: 'Alice', serif;">Nama</p>
                          </div>
                          <div class="col-lg-10">
                            <input type="text" name="nama" class="form-control" placeholder="Masukan Nama...">
                          </div>
                          <div class="col-lg-2 mt-2">
                            <p style="color: #272829; font-family: 'Alice', serif;">Email</p>
                          </div>
                          <div class="col-lg-10">
                            <input type="text" name="email" class="form-control" placeholder="Masukan Email...">
                          </div>
                          <div class="col-lg-2 mt-2">
                            <p style="color: #272829; font-family: 'Alice', serif;">Pesan</p>
                          </div>
                          <div class="col-lg-10">
                            <style>
                              .kirim{
                                  font-family: 'Alice', serif;
                                  background-color: #EEEEEE;
                                  color: #272829;
                                  border: none; /* Menghilangkan border */
                                  cursor: pointer;
                                }
                                .kirim:hover{
                                  background-color: #272829;
                                  color: #EEEEEE;
                                  border: none; /* Menghilangkan border */
                                  cursor: pointer;
                              }
                            </style>
                            <textarea name="message" class="form-control" id="message" cols="30" rows="3" placeholder="Masukan Pesan..."></textarea>
                            <button type="submit" class="btn kirim float-right mt-2">Kirim Pesan</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@include('customer.components.footer')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    @if($errors->any())
        $('#modal-default').modal('show'); // Menampilkan modal jika terjadi kesalahan validasi
    @endif
  });
</script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
      const inputElements = document.querySelectorAll('.motor-input');
      const radioElements = document.querySelectorAll('input[type="radio"]');
      const selectedNameInput = document.getElementById('selectedName');
      const submitButton = document.getElementById('submitButton');
      const animatedElement = document.getElementById("animated-element");

      const observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
            animatedElement.classList.add("animate__animated", "animate__fadeInRight");
            observer.unobserve(animatedElement); // Menghentikan pemantauan setelah elemen dianimasikan
          }
        });
      });

    // Mulai memantau elemen
    observer.observe(animatedElement);

      inputElements.forEach((input) => {
          input.style.display = 'none';
      });

    
      const urlParams = new URLSearchParams(window.location.search);
      const searchValue = urlParams.get('search');

      radioElements.forEach((radio) => {
          radio.addEventListener('change', (event) => {
              const itemName = event.target.value;

              inputElements.forEach((input) => {
                  input.style.display = 'none';
              });

              inputElements.forEach((input) => {
                  if (input.value === itemName) {
                      input.style.display = 'block';
                  }
              });

              selectedNameInput.value = itemName;

              if (event.target.checked) {
                  submitButton.click();
              }
          });
      });
  });
</script>
@endsection