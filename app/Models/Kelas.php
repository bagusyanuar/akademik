<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    protected $table = 'kelas';

    public function pelajaran()
    {
        return $this->hasMany(PelajaranKelas::class, 'kelas_id');
    }

    public function nilai()
    {
        return $this->hasOneThrough(Nilai::class, PelajaranKelas::class, 'kelas_id', 'pelajaran_kelas_id', 'id', 'id');
    }
}
