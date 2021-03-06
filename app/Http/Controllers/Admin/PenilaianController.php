<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\KelasSiswa;
use App\Models\MataPelajaran;
use App\Models\Nilai;
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
        $periode = Periode::orderBy('nama', 'DESC')->get();
        $authGuru = Guru::with(['user', 'kelas'])->where('user_id', auth()->id())->whereNotNull('kelas_id')->first();
        if (!$authGuru) {
            return view('main.dashboard');
        }

//        $siswa = Siswa::where('kelas_id', $authGuru->kelas_id)->get();
        $siswa = KelasSiswa::with(['siswa'])->where('periode_id', '=', $periode[0]->id)
            ->where('kelas_id', '=', $authGuru->kelas_id)
            ->get();
//        return $siswa->toArray();
        return view('main.penilaian.index')->with([
            'periode' => $periode,
            'siswa' => $siswa,
            'guru' => $authGuru
        ]);
    }

    public function getNilai()
    {
        try {
            $idSiswa = $this->field('siswa');
            $Idperiode = $this->field('periode');
            $semester = $this->field('semester');
            $authGuru = Guru::with('user')->where('user_id', auth()->id())->whereNotNull('kelas_id')->first();
            if (!$authGuru) {
                return $this->jsonResponse('Forbidden', 202);
            }
            $pelajaran = PelajaranKelas::with(['mataPelajaran', 'nilai' => function ($query) use ($idSiswa) {
                $query->where('kelas_siswa_id', $idSiswa);
            }])
                ->where('periode_id', $Idperiode)
                ->where('kelas_id', $authGuru->kelas_id)
                ->where('semester', $semester)
                ->get();
            return $this->jsonResponse('success',  200, $pelajaran);
        } catch (\Exception $e) {
            return $this->jsonResponse($e->getMessage(), 500);
        }
    }

    public function saveNilai()
    {
        try {
            $idSiswa = $this->postField('siswa');
            $idPelajaran = $this->postField('pelajaran');
            $nilai = $this->postField('nilai');

            $vNilai = Nilai::with('siswa')->where('pelajaran_kelas_id', $idPelajaran)->where('kelas_siswa_id', $idSiswa)->first();
            if(!$vNilai) {
                $newNilai = new Nilai();
                $newNilai->pelajaran_kelas_id = $idPelajaran;
                $newNilai->kelas_siswa_id = $idSiswa;
                $newNilai->nilai = $nilai;
                $newNilai->save();
            } else {
                $vNilai->nilai = $nilai;
                $vNilai->save();
            }
            return $this->jsonResponse('success',  200);

        }catch (\Exception $e) {
            return $this->jsonResponse($e->getMessage(), 500);
        }
    }

    public function justCheck()
    {
        try {
            $siswa = Siswa::with(['kelas.pelajaran'])
                ->get();

            return $this->jsonResponse('success',  200, $siswa);
        }catch (\Exception $e) {
            return $this->jsonResponse($e->getMessage(), 500);
        }
    }
}
