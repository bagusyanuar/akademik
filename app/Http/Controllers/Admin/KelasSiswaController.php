<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Kelas;
use App\Models\KelasSiswa;
use App\Models\Periode;
use App\Models\Siswa;

class KelasSiswaController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $periode = Periode::all();
        $kelas = Kelas::all();
        $siswa = Siswa::all();
//        return $periode->toArray();
        return view('main.akademik.kelas_siswa.index')->with(['periode' => $periode, 'kelas' => $kelas, 'siswa' => $siswa]);
    }

    public function getList()
    {
        try {
            $periode = $this->field('periode');
            $kelas = $this->field('kelas');
            $data = KelasSiswa::with(['siswa'])->where('periode_id', '=', $periode)
                ->where('kelas_id', '=', $kelas)
                ->get();
            return $this->basicDataTables($data);
        } catch (\Exception $e) {
            return $this->basicDataTables([]);
        }
    }

    public function register()
    {
        try {
            $data = KelasSiswa::with(['siswa', 'kelas'])->where('siswa_id', $this->postField('siswa'))
                ->where('periode_id', $this->postField('periode'))
                ->first();
            if ($data) {
                return $this->jsonResponse('Siswa Telah Terdaftar Di Kelas ' . $data->kelas->nama, 202);
            }

            KelasSiswa::create([
                'siswa_id' => $this->postField('siswa'),
                'periode_id' => $this->postField('periode'),
                'kelas_id' => $this->postField('kelas')
            ]);

            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            return $this->jsonResponse('gagal ' . $e->getMessage(), 500);
        }
    }
}
