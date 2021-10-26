<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\PelajaranKelas;
use App\Models\Periode;

class PelajaranKelasController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $periode = Periode::all();
        $kelas = Kelas::all();
        $mata_pelajaran = MataPelajaran::all();
        return view('main.akademik.pelajaran_kelas.index')->with([
            'periode' => $periode,
            'kelas' => $kelas,
            'mata_pelajaran' => $mata_pelajaran]);
    }

    public function getList()
    {
        try {
            $periode = $this->field('periode');
            $kelas = $this->field('kelas');
            $semester = $this->field('semester');
            $data = PelajaranKelas::with(['mataPelajaran'])
                ->where([
                    ['periode_id', '=', $periode],
                    ['semester', '=', $semester],
                    ['kelas_id', '=', $kelas],
                ])
                ->get();
            return $this->jsonResponse('success', 200, [
                'data' => $data
            ]);
        }catch (\Exception $e) {
            return $this->jsonResponse($e->getMessage(), 500);
        }

    }
}
