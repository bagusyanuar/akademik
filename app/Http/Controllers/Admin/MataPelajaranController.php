<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Kelas;
use App\Models\MataPelajaran;

class MataPelajaranController extends CustomController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = MataPelajaran::orderBy('nama', 'ASC')->get();
        return view('main.akademik.mata_pelajaran.index')->with(['data' => $data]);
    }

    public function addPage()
    {
        return view('main.akademik.mata_pelajaran.add');
    }
    public function store()
    {
        try {
            $name = $this->postField('name');
            $data = [
                'nama' => $name
            ];
            $this->insert(MataPelajaran::class, $data);
            return redirect()->back()->with(['success' => 'Berhasil Menambahkan Data Mata Pelajaran...']);
        }catch (\Exception $e){
            return redirect()->back()->with(['failed' => 'Terjadi Kesalahan...']);
        }
    }

    public function editPage($id)
    {
        $data = MataPelajaran::where('id', $id)->firstOrFail();
        return view('main.akademik.mata_pelajaran.edit')->with(['data' => $data]);
    }

    public function patch()
    {
        try {
            $id = $this->postField('id');
            $name = $this->postField('name');
            $mata_pelajaran = MataPelajaran::find($id);
            $mata_pelajaran->nama = $name;
            $mata_pelajaran->save();
            return redirect('/mata-pelajaran');
        } catch (\Exception $e) {
            return redirect()->back()->with(['failed' => 'Terjadi Kesalahan...' . $e]);
        }
    }

    public function destroy($id)
    {
        try {
            MataPelajaran::destroy($id);
            return response()->json([
                'msg' => 'success',
                'code' => 200
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Terjadi Kesalahan' . $e,
                'code' => 500
            ]);
        }
    }
}
