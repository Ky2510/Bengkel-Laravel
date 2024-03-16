<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LayananService extends Model
{
    use HasFactory;
    protected $fillable = ['id_layanan','id_datauser','barang','keluhan','status', 'nama_motor', 'jenis_motor', 'id_anggota', 'harga'];
    protected $table = 'layanan_services';


    public function datauser(): BelongsTo
    {
        return $this->belongsTo(Datauser::class, 'id_datauser');
    }
    
    public function barang(): BelongsTo
    {
        return $this->BelongsTo(Barang::class, 'id_barang');
    }

    public function anggota(): BelongsTo
    {
        return $this->BelongsTo(Anggota::class, 'id_anggota');
    }
}
