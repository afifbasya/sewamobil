<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    use HasFactory;

    protected $fillable = [
        'merek',
        'model',
        'nomor_plat',
        'tarif',
        'ketersediaan'
    ];

    public function pinjams()
    {
        return $this->hasMany(Pinjam::class, 'mobil_id');
    }
}
