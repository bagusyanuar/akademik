<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Guru;
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
            return view('main.dashboard');
        }
        return view('main.raport.index')->with([
            'periode' => $periode,
            'guru' => $authGuru
        ]);
    }

    public function getRaport()
    {
        try {
            $siswa = Siswa::with(['kelas.pelajaran'
            => function ($q) {
                    $q->addSelect(DB::raw('(SELECT nilai from nilai where nilai.pelajaran_kelas_id = pelajaran_kelas.id AND nilai.siswa_id = siswa.id) as nilai'));
                }
            ])
                ->where('kelas_id', 6)
                ->get();
            return $this->jsonResponse(['data' => $siswa], 200);
        }catch (\Exception $e) {
            return $this->jsonResponse('gagal '.$e->getMessage(), 500);
        }
    }
}
