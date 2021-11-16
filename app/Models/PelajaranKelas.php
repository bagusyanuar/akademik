<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelajaranKelas extends Model
{
    use HasFactory;
    protected $table = 'pelajaran_kelas';

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'periode_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }

    public function nilai()
    {
        return $this->hasOne(Nilai::class, 'pelajaran_kelas_id')->select(['pelajaran_kelas_id', 'nilai'])->orderBy('nilai', 'DESC');
    }

}
