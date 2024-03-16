<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suplay extends Model
{
    use HasFactory;
    protected $fillable = ['nama', 'no_hp', 'alamat'];
    protected $table = 'suplay';
}
