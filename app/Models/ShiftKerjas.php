<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftKerjas extends Model
{
    use HasFactory;

    protected $table = 'shift_kerjas'; // Nama tabel eksplisit

    protected $guarded = [];
}
