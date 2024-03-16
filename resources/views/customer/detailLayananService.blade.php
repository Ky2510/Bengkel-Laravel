@extends('layouts.index')

@section('menuNavbar')
  @include('customer.components.menuNavbar')
@endsection

@section('content')
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Alice&family=Pacifico&family=Play:wght@700&display=swap" rel="stylesheet">
  <section class="content">
    <div class="container-fluid">
      <div class="row mt-5">
        <div class="col-12">
          <!-- Main content -->
          <div class="invoice p-3 mb-3">
            <!-- title row -->
            <div class="row">
              <div class="col-12">
                <h4>
                  <i class="fas fa-globe"></i> {{ $layanan->id_layanan }}.
                  <small class="float-right">{{ \Carbon\Carbon::parse($layanan->created_at)->isoFormat('D MMMM YYYY') }}</small>
                </h4>
              </div>
              <!-- /.col -->
            </div>
            <div class="row">
              @php
                  $dataUser = App\Models\Datauser::where('id_user', $layanan->id_datauser)->first()
              @endphp
              <div class="col-6">
                <h5 class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                  <b>Nama</b> =
                  {{ $dataUser->namaPertama }} {{ $dataUser->namaTerakhir }}<br>
                  <b>No.HP</b> =
                  {{ $dataUser->no_hp }}<br>
                  <b>Motor</b> =
                  {{ $layanan->nama_motor }} {{ $layanan->jenis_motor }} <br>
                  <b>Alamat</b> =
                  {{ $dataUser->alamat }}<br>
                  <b>Keluhan</b> =
                  {{ $layanan->keluhan }}
                </h5>
              </div>
              <div class="col-6">
                <p class="lead">Tambahan Barang (Stok Barang)</p>
                <div class="table-responsive">
                  @php
                    $dataUser = App\Models\Datauser::where('id_user', $layanan->id_datauser)->get();
                    $dataAnggota = App\Models\Anggota::where('user_id', $layanan->id_anggota)->get();
                    $dataBarang = App\Models\ServiceBarang::where('id_layananservice', $layanan->id)->get();
                    $totalHarga = 0;
                  @endphp
                  <table class="table">
                    @foreach ($dataBarang as $itemBarang)
                      @php
                        $totalHarga += $itemBarang->barang->hargaJual * $itemBarang->stok_barang;
                      @endphp
                      @if ($itemBarang->id_barang !== null && $itemBarang->stok_barang !== null)
                        <tr>
                          <th style="width:50%">Barang:</th>
                          <td>{{ $itemBarang->barang->nama }} ({{ $itemBarang->stok_barang }})</td>
                        </tr>
                        <tr>
                          <th style="width:50%">Harga barang /1:</th>
                          <td>Rp.{{ $itemBarang->barang->hargaJual }}</td>
                        </tr>
                        <tr>
                          <th style="width:50%">Biaya Sewa:</th>
                          <td>Rp.{{ $layanan->harga }}</td>
                        </tr>
                        <tr>
                          <th> Total:</th>
                          <td>Rp. {{ $totalHarga + $layanan->harga }}</td>
                        </tr>
                      @endif
                    @endforeach
                  </table>
                </div>
              </div>
              <!-- /.col -->
            </div>
          </div>
          <!-- /.invoice -->
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection