<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    use HasFactory;
    protected $table = 'absen';

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function absen()
    {
        return $this->hasMany(AbsenSiswa::class, 'absen_id');
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'periode_id');
    }

    public function nilaiabsen()
    {
        return $this->hasOne(AbsenSiswa::class, 'absen_id')->select(['absen_id', 'nilai', 'keterangan']);
    }
}
