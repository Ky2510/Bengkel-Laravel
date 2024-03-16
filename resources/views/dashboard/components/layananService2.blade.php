<div class="table-responsive mailbox-messages">
    <table class="table table-hover table-striped">
        <tbody>
            @foreach ($layananService as $item)
                @php
                    $dataUser = App\Models\Datauser::where('id_user', $item->id_datauser)->get()
                @endphp
                @if ($item->status == 'konfirmasi' && $item->id_anggota == auth()->user()->id)
                    <tr>
                        <td class="mailbox-subject"><b>{{ $item->id_layanan }}</b> <br></td>
                        <td class="mailbox-attachment">
                            <button class="btn btn-xs btn-info" data-toggle="modal" data-target="#modal-layananConf{{ $item->id }}"><i class="fa-solid fa-eye"></i></button>
                            <div class="modal fade" id="modal-layananConf{{ $item->id }}">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h4 class="modal-title">
                                            Tambahan barang dalam service motor
                                        </h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <div class="modal-body" id="modal-layananConf{{ $item->id }}">
                                            <ul>
                                                <li>{{ $item->nama_motor }} ({{ $item->jenis_motor }})</li>
                                                <b>Keluhan</b> <br>
                                                <i>{{ $item->keluhan }}</i> <br>
                                                <b>Barang</b> <br>
                                        
                                                <ol>
                                                    @foreach ($serviceBarang as $itemLyn)
                                                        @if ($itemLyn->id_barang !== null && $itemLyn->stok_barang !== null && $itemLyn->id_layananservice == $item->id)
                                                            <li>Barang : {{ $itemLyn->barang->nama }} | Stok : {{ $itemLyn->stok_barang }}</li>
                                                        @endif
                                                    @endforeach
                                                </ol>
                                            </ul>
                                            @if ($item->barang !== 'true')
                                                {!! Form::model($model, ['route' => 'layanan.store','method' => 'POST', 'files' => true]) !!}
                                                    <input type="hidden" name="id_layananservice" value="{{ $item->id }}">
                                                    <div class="form-group mt-3">
                                                        {!! Form::select('id_barang', $listBarang, old('id_barang'), ['class' => 'form-control select2bs4 ', 'placeholder' => 'Pilih Barang']) !!}
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::number('stok_barang', old('stok_barang'), ['class' => 'form-control ', 'placeholder' => "Masukan jumlah ..."]) !!}
                                                    </div>
                                                    @if ($item->harga == null)
                                                        <div class="form-group">
                                                            {!! Form::number('harga', old('harga'), ['class' => 'form-control', 'placeholder' => "Masukan biaya service ...",  'name' => 'harga', 'id' => 'harga-input']) !!}
                                                        </div>
                                                    @else
                                                        <p><b>Biaya service : Rp.{{ $item->harga }}</b></p>
                                                    @endif
                                                    <div class="float-right mt-2">
                                                        <button type="submit" class="btn btn-info btn-sm" id="submit-barang-button">
                                                            Submit Barang 
                                                        </button> <br>
                                                    </div>
                                                {!! Form::close() !!} 
                                            @else
                                                <center><button class="badge badge-md badge-success">Rp.{{ $item->harga }}</button></center>
                                                <center><button class="badge badge-md badge-success">Sudah Selesai Service</button></center>
                                            @endif
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                            @if ($item->barang !== 'true')
                                                <a href="{{ route('layanankonfirmasi.store', [
                                                    'model' => 'layanankonfirmasi',
                                                    'id' => $item->id,
                                                    ]) }}" class="btn btn-success btn-sm">
                                                    Selesai 
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> 
@php
    $reportLayananService1 = App\Models\LayananService::all();
@endphp
@if ($reportLayananService1->count() > 0)
    <script>
        $(document).ready(function() {
            $('#submit-barang-button').on('click', function(e) {
                $('#modal-layananConf{{ $item->id }}').modal('show');
            });
        });
    </script>
@endif
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