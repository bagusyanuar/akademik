<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Admin;
use App\Models\MataPelajaran;
use App\Models\Periode;

class PeriodeController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = Periode::orderBy('nama', 'ASC')->get();
        return view('main.akademik.periode.index')->with(['data' => $data]);
    }

    public function addPage()
    {
        return view('main.akademik.periode.add');
    }

    public function store()
    {
        try {
            $start = $this->postField('start');
            $end = $this->postField('end');
            $data = [
                'nama' => $start . '/' . $end
            ];
            $this->insert(Periode::class, $data);
            return redirect()->back()->with(['success' => 'Berhasil Menambahkan Data Periode...']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['failed' => 'Terjadi Kesalahan...']);
        }
    }
}
