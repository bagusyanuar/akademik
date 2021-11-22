<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Absen;
use App\Models\AbsenSiswa;
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
                ->orderBy('tanggal', 'DESC')
                ->get();
            return $this->basicDataTables($data);
        } catch (\Exception $e) {
            return $this->jsonResponse($e->getMessage(), 500);
        }
    }

    public function createAbsen()
    {
        try {
            $periode = $this->postField('periode');
            $kelas = $this->postField('kelas');
            $semester = $this->postField('semester');
            $tanggal = $this->postField('tanggal');

            $isExist  =  Absen::where('periode_id', $periode)
                ->where('kelas_id', $kelas)
                ->where('semester', $semester)
                ->where('tanggal', $tanggal)
                ->first();

            if($isExist) {
                return $this->jsonResponse('Absensi Sudah DI Buat!', 202);
            }

            $absen = new Absen();
            $absen->periode_id = $periode;
            $absen->kelas_id = $kelas;
            $absen->semester = $semester;
            $absen->tanggal = $tanggal;
            $absen->save();
            return $this->jsonResponse('success', 200, $absen->id);
        }catch (\Exception $e) {
            return $this->jsonResponse($e->getMessage(), 500);
        }
    }

    public function absenDetail($id)
    {
        $absen = Absen::with(['absen', 'kelas', 'periode'])->where('id', $id)->firstOrFail();
        $authGuru = Guru::with(['user', 'kelas'])->where('user_id', 8)->whereNotNull('kelas_id')->first();
        if (!$authGuru) {
            return view('main.dashboard');
        }

        $siswa = Siswa::where('kelas_id', $authGuru->kelas_id)->get();
        return view('main.absensi.detail')->with([
            'absen' => $absen,
            'siswa' => $siswa
        ]);
    }

    public function createAbsenSiswa()
    {
        try {
            $nilai = $this->postField('absen');
            $absenId = $this->postField('id');
            $siswa = $this->postField('siswa');
            $keterangan = $this->postField('keterangan');

            $isExist = AbsenSiswa::with(['absen', 'siswa'])
                ->where('absen_id', $absenId)
                ->where('siswa_id', $siswa)
                ->first();
            if($isExist) {
                return $this->jsonResponse('Siswa Sudah Melakukan Absen Hari Ini.', 202);
            }

            $absen = new AbsenSiswa();
            $absen->absen_id = $absenId;
            $absen->siswa_id = $siswa;
            $absen->nilai = $nilai;
            $absen->keterangan = $keterangan;
            $absen->save();

            return $this->jsonResponse('success', 200);
        }catch (\Exception $e) {
            return $this->jsonResponse($e->getMessage(), 500);
        }
    }

    public function listAbsenSiswa()
    {
        try {
            $id = $this->field('id');
            $data = AbsenSiswa::with(['absen', 'siswa'])
                ->where('absen_id', $id)
                ->get();
            return $this->basicDataTables($data);
        }catch (\Exception $e) {
            return $this->jsonResponse($e->getMessage(), 500);
        }
    }
}
