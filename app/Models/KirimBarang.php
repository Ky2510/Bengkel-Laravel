<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KirimBarang extends Model
{
    use HasFactory;
    protected $fillable = ['id_checkout','id_anggota', 'status_barang', 'konfirmasi_barang'];
    protected $table = 'kirim_barangs';

    public function checkout(): BelongsTo
    {
        return $this->BelongsTo(Checkout::class, 'id_checkout');
    }

    public function anggota(): BelongsTo
    {
        return $this->BelongsTo(Anggota::class, 'id_anggota');
    }
}
