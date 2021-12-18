<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;
    protected $table = 'nilai';

    public function pelajaran()
    {
        return $this->belongsTo(PelajaranKelas::class, 'pelajaran_kelas_id');
    }
}
