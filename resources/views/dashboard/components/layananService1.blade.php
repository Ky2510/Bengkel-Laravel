<div class="table-responsive mailbox-messages">
    <table class="table table-hover table-striped">
      <tbody>
        @foreach ($layananService as $item)
            @php
                $dataUser = App\Models\Datauser::where('id_user', $item->id_datauser)->get()
            @endphp
            @if ($item->status == 'belum konfirmasi')
            <tr>
                <td class="mailbox-name">
                    <a href="read-mail.html">
                        @foreach ($dataUser as $itemUser)
                            {{ $itemUser->namaPertama }} {{ $itemUser->namaTerakhir }}
                        @endforeach
                    </a>
                </td>
                <td class="mailbox-subject"><b>{{ $item->id_layanan }}</b> <br></td>
                <td class="mailbox-attachment">
                    <button class="btn btn-xs btn-info" data-toggle="modal" data-target="#modal-layananConf{{ $item->id }}"><i class="fa-solid fa-eye"></i></button>
                    <div class="modal fade" id="modal-layananConf{{ $item->id }}">
                        <div class="modal-dialog modal-md">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h4 class="modal-title">
                                @foreach ($dataUser as $itemUser)
                                    {{ $itemUser->namaPertama }} {{ $itemUser->namaTerakhir }}
                                @endforeach
                            </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body" id="modal-layananConf{{ $item->id }}">
                                <ul>
                                    <li>{{ $item->nama_motor }} ({{ $item->jenis_motor }})</li>
                                    <b>Keluhan</b> <br>
                                    <i>{{ $item->keluhan }}</i>
                                </ul>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                <a href="{{ route('layanankonfirmasi.update', [
                                    'model' => 'layananservices',
                                    'id' => $item->id,
                                    ]) }}" class="btn btn-success btn-sm">
                                    Submit
                                </a>
                            </div>
                        </div>
                        </div>
                    </div>
                </td>
                <td class="text-muted">{{ $item->created_at->diffForHumans(['locale' => 'id']) }}</td>
            </tr>
            @endif
        @endforeach
      </tbody>
    </table>
  </div>