<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Keranjang extends Model
{
    use HasFactory;
    protected $fillable = ['id_user','id_kategori', 'id_barang','id_merek', 'id_satuan', 'id_pembelian', 'quantity', 'status'];
    protected $table = 'keranjang';


    public function barang(): BelongsTo
    {
        return $this->BelongsTo(Barang::class, 'id_barang');
    }
    
    public function kategori(): BelongsTo
    {
        return $this->BelongsTo(Kategori::class, 'id_kategori');
    }

    public function pembelian(): BelongsTo
    {
        return $this->BelongsTo(Pembelian::class, 'id_pembelian');
    }

    public function merek(): BelongsTo
    {
        return $this->BelongsTo(Merek::class, 'id_merek');
    }

    public function satuan(): BelongsTo
    {
        return $this->BelongsTo(Satuan::class, 'id_satuan');
    }
}
