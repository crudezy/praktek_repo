<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coas extends Model
{
    use HasFactory;
    protected $table = 'coas'; // Nama tabel eksplisit

    protected $guarded = [];

}
