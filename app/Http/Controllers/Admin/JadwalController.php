<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\MataPelajaran;

class JadwalController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function store()
    {
        try {
            $periode = $this->postField('periode');
            $hari = $this->postField('hari');
            $kelas = $this->postField('kelas');
            $mata_pelajaran = $this->postField('mata_pelajaran');
            $data = [
                'periode_id' => $periode,
                'hari' => $hari,
                'kelas_id' => $kelas,
                'mata_pelajaran_id' => $mata_pelajaran,
            ];
            $this->insert(MataPelajaran::class, $data);
            return $this->jsonResponse('success', 200);
        }catch (\Exception $e){
            return $this->jsonResponse($e->getMessage(), 500);
        }
    }

    public function getJadwal()
    {
        try {
            $data = Jadwal::with(['periode', 'kelas', 'mataPelajaran'])->get();
            return $this->jsonResponse([
                'msg' => 'success',
                'data' => $data
            ], 200);
        }catch (\Exception $e){
            return $this->jsonResponse($e->getMessage(), 500);
        }
    }
}