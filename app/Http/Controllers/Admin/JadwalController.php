<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\PelajaranKelas;
use App\Models\Periode;

class JadwalController extends CustomController
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
        return view('main.akademik.jadwal.index')->with([
            'periode' => $periode,
            'kelas' => $kelas,
            'mata_pelajaran' => $mata_pelajaran]);
    }

    public function getSubjectBy()
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
                ])->get();
            return $this->jsonResponse('success', 200, [
                'data' => $data
            ]);
        }catch (\Exception $e) {
            return $this->jsonResponse($e->getMessage(), 500);
        }
    }

    public function store()
    {
        try {
            $periode = $this->postField('periode');
            $hari = $this->postField('hari');
            $kelas = $this->postField('kelas');
            $mata_pelajaran = $this->postField('mata_pelajaran');
            $mulai = $this->postField('mulai');
            $selesai = $this->postField('selesai');
            $semester = $this->postField('semester');
            $data = [
                'periode_id' => $periode,
                'hari' => $hari,
                'kelas_id' => $kelas,
                'mata_pelajaran_id' => $mata_pelajaran,
                'mulai' => $mulai,
                'selesai' => $selesai,
                'semester' => $semester,
            ];
            $this->insert(Jadwal::class, $data);
            $jadwal = Jadwal::with(['periode', 'kelas', 'mataPelajaran'])
                ->where([
                    ['periode_id', '=', $periode],
                    ['semester', '=', $semester],
                    ['kelas_id', '=', $kelas],
                    ['hari', '=', $hari],
                ])
                ->orderBy('mulai', 'ASC')
                ->get();
            return $this->jsonResponse('success', 200, [
                'data' => $jadwal
            ]);
        } catch (\Exception $e) {
            return $this->jsonResponse($e->getMessage(), 500);
        }
    }

    public function getJadwal()
    {
        try {
            $periode = $this->field('periode');
            $kelas = $this->field('kelas');
            $semester = $this->field('semester');
            $data = Jadwal::with(['periode', 'kelas', 'mataPelajaran'])
                ->where([
                    ['periode_id', '=', $periode],
                    ['semester', '=', $semester],
                    ['kelas_id', '=', $kelas],
                ])
                ->orderBy('mulai', 'ASC')
                ->get();
            $data = $data->groupBy('hari');
            return $this->jsonResponse('success', 200, [
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return $this->jsonResponse($e->getMessage(), 500);
        }
    }

    public function destroy()
    {
        try {
            $periode = $this->postField('periode');
            $kelas = $this->postField('kelas');
            $semester = $this->postField('semester');
            $hari = $this->postField('hari');
            $id = $this->postField('id');
            Jadwal::destroy($id);
            $jadwal = Jadwal::with(['periode', 'kelas', 'mataPelajaran'])
                ->where([
                    ['periode_id', '=', $periode],
                    ['semester', '=', $semester],
                    ['kelas_id', '=', $kelas],
                    ['hari', '=', $hari],
                ])
                ->orderBy('mulai', 'ASC')
                ->get();
            return $this->jsonResponse('success', 200, [
                'data' => $jadwal
            ]);
        } catch (\Exception $e) {
            return $this->jsonResponse($e->getMessage(), 500);
        }
    }
}
