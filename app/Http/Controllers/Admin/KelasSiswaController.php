<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Kelas;
use App\Models\Periode;

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
        return view('main.akademik.kelas_siswa.index')->with(['periode' => $periode, 'kelas' => $kelas]);
    }
}
