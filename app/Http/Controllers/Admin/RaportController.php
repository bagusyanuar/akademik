<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Absen;
use App\Models\Guru;
use App\Models\Nilai;
use App\Models\PelajaranKelas;
use App\Models\Periode;
use App\Models\Siswa;
use Illuminate\Support\Facades\DB;

class RaportController extends CustomController
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
            return view('main.raport.index');
        }
        return view('main.raport.index')->with([
            'periode' => $periode,
            'guru' => $authGuru
        ]);
    }

    public function getRaport()
    {
        try {
            $periode = $this->field('periode');
            $semester = $this->field('semester');
            $kelas = $this->field('kelas');
            $siswa = Siswa::with(['kelas.pelajaran.mataPelajaran', 'kelas.pelajaran' => function ($query) use ($periode, $semester) {
                return $query->where('periode_id', '=', $periode)
                    ->where('semester', '=', $semester);
            }
            ])
                ->where('kelas_id', $kelas)
                ->get();

            $results = [];
            foreach ($siswa as $v) {
                $tmp['id'] = $v->id;
                $tmp['nama'] = $v->nama;
                $tmp['kelas'] = $v->kelas->nama;
                $tmp['pelajaran'] = [];

                foreach ($v->kelas->pelajaran as $key => $pelajaran) {
                    $tmpPelajaran['nama'] = $pelajaran->mataPelajaran->nama;
                    $tmpPelajaran['nilai'] = 0;
                    $nilai = Nilai::where('pelajaran_kelas_id', '=', $pelajaran->id)
                        ->where('siswa_id', '=', $v->id)->first();
                    if ($nilai) {
                        $tmpPelajaran['nilai'] = $nilai->nilai;
                    }
                    array_push($tmp['pelajaran'], $tmpPelajaran);
                }

                $tmp['rata_rata'] = count($tmp['pelajaran']) > 0 ? array_sum($tmpAve = array_column($tmp['pelajaran'], 'nilai')) / count($tmp['pelajaran']) : 0;
                array_push($results, $tmp);
            }
            return $this->basicDataTables($results);
        } catch (\Exception $e) {
            return $this->basicDataTables([]);
        }
    }

    public function getDetailRaport()
    {
        try {
            $semester = $this->field('semester');
            $periode = $this->field('periode');
            $kelas = $this->field('kelas');
            $siswa = $this->field('siswa');
            $pelajaran = PelajaranKelas::with(['mataPelajaran', 'nilai' => function ($query) use ($siswa) {
                $query->where('siswa_id', $siswa);
            }])
                ->where('periode_id', $periode)
                ->where('kelas_id', $kelas)
                ->where('semester', $semester)
                ->get();

            $absensi = Absen::with(['kelas', 'nilaiabsen' => function ($query) use ($siswa) {
                return $query->where('siswa_id', $siswa);
            }])->where('periode_id', $periode)
                ->where('kelas_id', $kelas)
                ->where('semester', $semester)
                ->get();

            $jumlahAbsensi = count($absensi);
            $masuk = $absensi->filter(function ($v, $k) {
                return $v->nilaiabsen !== null && $v->nilaiabsen->nilai === "masuk";
            });
            $ijin = $absensi->filter(function ($v, $k) {
                return $v->nilaiabsen !== null && $v->nilaiabsen->nilai === "ijin";
            });
            $alpha = $absensi->filter(function ($v, $k) {
                return $v->nilaiabsen !== null && $v->nilaiabsen->nilai === "alpha";
            });
            $jumlahMasuk = count($masuk->all());
            $jumlahIjin = count($ijin->all());
            $jumlahAlpha = count($alpha->all());
            return $this->jsonResponse('success', 200, [
                'pelajaran' => $pelajaran,
                'absen' => [
                    'total' => $jumlahAbsensi,
                    'masuk' => $jumlahMasuk,
                    'ijin' => $jumlahIjin,
                    'alpha' => $jumlahAlpha,
                    'kosong' => $jumlahAbsensi - ($jumlahMasuk + $jumlahIjin + $jumlahAlpha)
                ]
            ]);
        } catch (\Exception $e) {
            return $this->jsonResponse('Gagal ' . $e->getMessage(), 500);
        }
    }
}
