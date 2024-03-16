<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembelian extends Model
{
    use HasFactory;
    protected $fillable = ['nama', 'jenis', 'hargaBeli', 'hargaJual', 'stok', 'id_suplay'];
    protected $table = 'pembelian';

    public function suplay(): BelongsTo
    {
        return $this->BelongsTo(Suplay::class, 'id_suplay');
    }
}
