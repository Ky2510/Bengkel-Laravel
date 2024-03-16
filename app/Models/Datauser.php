<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Datauser extends Model
{
    use HasFactory;
    protected $fillable = ['namaPertama', 'namaTerakhir', 'no_hp', 'alamat', 'id_user'];
    protected $table = 'datauser';


    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class, 'id_user');
    }
}
