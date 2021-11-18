<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Absen;
use App\Models\Guru;
use App\Models\Periode;
use App\Models\Siswa;

class AbsensiController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $periode = Periode::orderBy('nama', 'DESC')->get();
        $authGuru = Guru::with(['user', 'kelas'])->where('user_id', 8)->whereNotNull('kelas_id')->first();
        if (!$authGuru) {
            return view('main.dashboard');
        }

        $siswa = Siswa::where('kelas_id', $authGuru->kelas_id)->get();
        return view('main.absensi.index')->with([
            'periode' => $periode,
            'siswa' => $siswa,
            'guru' => $authGuru
        ]);
    }

    public function getList()
    {
        try {
            $periode = $this->field('periode');
            $kelas = $this->field('kelas');
            $semester = $this->field('semester');
            $data = Absen::with(['kelas', 'absen'])
                ->where('periode_id', $periode)
                ->where('kelas_id', $kelas)
                ->where('semester', $semester)
                ->get();
            return $this->basicDataTables($data);
        } catch (\Exception $e) {
            return $this->jsonResponse($e->getMessage(), 500);
        }
    }
}
