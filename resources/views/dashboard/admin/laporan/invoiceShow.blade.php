<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bengkel Mandiri Jaya Motor | Invoice</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('template') }}/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('template') }}/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
                <div class="container">
                    <div class="callout callout-info">
                      <h5><i class="fas fa-info"></i> Note:</h5>
                      Halaman ini telah disempurnakan untuk dicetak. Klik tombol cetak di bagian bawah transaksi untuk dicetak.
                    </div>
                </div>
    
              <!-- Main content -->
              <div class="container">
                <div class="invoice p-3 mb-3">
                    <!-- title row -->
                    <div class="row">
                      <div class="col-12">
                        <h4>
                          <i class="fas fa-globe"></i> Bengkel Mandiri Jaya Motor
                          <small class="float-right">Tanggal: {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}</small>
                        </h4>
                      </div>
                      <!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                      <div class="col-sm-4 invoice-col">
                        Dari
                        <address>
                          <strong> {{ $namaAdmin }}</strong><br>
                          {{ $alamatAdmin }}<br>
                          Email: {{ auth()->user()->email }}
                        </address>
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-4 invoice-col">
                        Kepada
                        <address>
                          <strong>{{ $namaPertamaCustomer }} {{ $namaTerakhirCustomer }}</strong><br>
                          {{ $alamatCustomer }}<br>
                          Email: {{ $items->user->email }}
                        </address>
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-4 invoice-col">
                        <b>Invoice #{{ $invoiceIDAwal }}{{ \Carbon\Carbon::now()->format('Y') }}{{ $invoiceIDTengah }}{{ \Carbon\Carbon::now()->format('m') }}{{ $invoiceIDAkhir }}{{ \Carbon\Carbon::now()->format('d') }}{{ $items->id + 1 }}</b><br>
                        <br>
                        <b>Transaksi ID:</b> {{ $items->id_transaksi }}<br>
                        <b>Tanggal Pembayaran:</b>{{ \Carbon\Carbon::parse($items->created_at)->isoFormat('D MMMM YYYY') }}<br>
                      </div>
                      <!-- /.col -->
                    </div>
                    <!-- /.row -->
        
                      <div class="row">
                          <div class="col-12 col-sm-6">
                            <h3 class="d-inline-block d-sm-none">LOWA Men’s Renegade GTX Mid Hiking Boots Review</h3>
                            <div class="col-12 mt-2">
                              <img src="{{ \Storage::url($items->keranjang->barang->image) }}" class="product-image" alt="Product Image">
                            </div>
                          </div>
                          <div class="col-12 col-sm-6">
                            <h3 class="my-3">
                                {{ $items->keranjang->barang->pembelian->nama }}
                            </h3>
                            <hr>
                            <div class="row">
                                <div class="col-lg-6">
                                  <p>
                                      <b>Kategori </b> : <i>{{ $items->keranjang->kategori->nama }}</i><br>
                                      <b>Merek  </b> : <i>{{ $items->keranjang->merek->nama }}</i><br>
                                      <b>Jenis Motor </b> : <i>{{ $items->keranjang->pembelian->jenis }}</i><br>
                                      <b>Jumlah </b> : <i>{{ $items->keranjang->quantity }} {{ $items->keranjang->satuan->nama }}</i><br>
                                      <b>Harga </b> : <i>Rp.{{ $items->keranjang->pembelian->hargaJual }}</i><br>
                                      <b>Status </b> :  @if ($items->keranjang->status == 'Sudah dibayar')
                                                          <button class="badge badge-xs badge-success">Sudah dibayar</button>
                                                        @else
                                                          <button class="badge badge-xs badge-warning">Belum dibayar</button>
                                                        @endif<br>
                                    </p>
                                </div>
                                <div class="col-lg-6 mt-4">
                                    <h3>Total : <b>Rp.{{ $items->keranjang->quantity * $items->keranjang->pembelian->hargaJual  }}</b></h3>
                                </div>
                            </div>
                          </div>
                      </div>
        
                    <div class="row">
                      <!-- accepted payments column -->
                      <div class="col-6">
                        <p><b><i>dari :</i></b></p>
                        <p class="lead">Metode Pembayaran (Bank <b>Tranfer Rek.</b>):</p>
                        <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                          Nama Bank  : {{ $items->bank->nama_bank }} <br>
                          Atas Nama  : {{ $items->namaRek }} <br>
                          Nomor Rek. : {{ $items->noRek }} <br>
                        </p>
                    </div>
                    <div class="col-6">
                        <p><b><i>ditransfer ke :</i></b></p>
                          <p class="lead">Metode Pembayaran (Bank <b>Tranfer Rek.</b>):</p>
                          <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                            Nama Bank  : {{ $items->bank->nama_bank }} <br>
                            Atas Nama  : {{ $items->bank->nama_rekening }} <br>
                            Nomor Rek. : {{ $items->bank->nomor_rekening }} <br>
                          </p>
                      </div>
                      <!-- /.col -->
                    </div>
                    <!-- /.row -->
        
                    <!-- this row will not appear when printing -->
                    <div class="row no-print">
                      <div class="col-12">
                        <button type="button" id="btnPrint" class="btn btn-primary float-right" style="margin-right: 5px;">
                          <i class="fas fa-download"></i> Cetak
                        </button>
                      </div>
                    </div>
                  </div>
              </div>
              <!-- /.invoice -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <script>
         document.getElementById('btnPrint').addEventListener('click', function() {
            window.print();
        });
    </script>
</body>