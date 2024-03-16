<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceBarang extends Model
{
    use HasFactory;
    protected $fillable = ['id_layananservice','id_barang','stok_barang', 'id_anggota'];
    protected $table = 'service_barangs';


    public function layananservice(): BelongsTo
    {
        return $this->belongsTo(LayananService::class, 'id_layananservice');
    }

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Pembelian::class, 'id_barang');
    }
}
