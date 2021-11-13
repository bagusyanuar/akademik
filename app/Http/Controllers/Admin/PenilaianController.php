<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\PelajaranKelas;
use App\Models\Periode;
use App\Models\Siswa;

class PenilaianController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $idSiswa = $this->field('siswa');
        $Idperiode = $this->field('periode');
        $semester = $this->field('semester');
        $periode = Periode::all();
        $authGuru = Guru::with('user')->where('user_id', 8)->whereNotNull('kelas_id')->first();
        if (!$authGuru) {
            return view('main.dashboard');
        }

        $siswa = Siswa::where('kelas_id', $authGuru->kelas_id)->get();
        $id = 3;
//        $subQuery =
        $pelajaran = PelajaranKelas::with(['mataPelajaran', 'nilai' => function ($query) use ($idSiswa) {
            $query->where('siswa_id', $idSiswa);
        }])
            ->where('periode_id', $Idperiode)
            ->where('kelas_id', $authGuru->kelas_id)
            ->where('semester', $semester)
            ->get();

        return $pelajaran->toArray();
        return view('main.penilaian.index')->with([
            'periode' => $periode,
            'siswa' => $siswa,
            'pelajaran' => $pelajaran
        ]);
    }
}
