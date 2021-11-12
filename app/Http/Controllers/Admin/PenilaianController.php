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
        $periode = Periode::all();
        $authGuru = Guru::with('user')->where('user_id', 8)->whereNotNull('kelas_id')->first();
        if (!$authGuru) {
            return view('main.dashboard');
        }

        $siswa = Siswa::where('kelas_id', $authGuru->kelas_id)->get();
        $subQuery =
        $pelajaran = PelajaranKelas::with(['mataPelajaran', 'nilai'])
            ->where('periode_id', 1)
            ->where('kelas_id', $authGuru->kelas_id)
            ->where('semester', 1)
            ->get();

        return $pelajaran->toArray();
        return view('main.penilaian.index')->with([
            'periode' => $periode,
            'siswa' => $siswa,
            'pelajaran' => $pelajaran
        ]);
    }
}
