<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Admin;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KelasController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = Kelas::orderBy('nama', 'ASC')->get();
        return view('main.akademik.kelas.index')->with(['data' => $data]);
    }

    public function addPage()
    {
        return view('main.akademik.kelas.add');
    }
    public function store()
    {
        try {
            $name = $this->postField('name');
            $data = [
                'nama' => $name
            ];
            $this->insert(Kelas::class, $data);
            return redirect()->back()->with(['success' => 'Berhasil Menambahkan Data Kelas...']);
        }catch (\Exception $e){
            return redirect()->back()->with(['failed' => 'Terjadi Kesalahan...']);
        }
    }

    public function editPage($id)
    {
        $data = Kelas::where('id', $id)->firstOrFail();
        return view('main.akademik.kelas.edit')->with(['data' => $data]);
    }

    public function patch()
    {
        try {
            $id = $this->postField('id');
            $name = $this->postField('name');
            $kelas = Kelas::find($id);
            $kelas->nama = $name;
            $kelas->save();
            return redirect('/kelas');
        } catch (\Exception $e) {
            return redirect()->back()->with(['failed' => 'Terjadi Kesalahan...' . $e]);
        }
    }

    public function destroy($id)
    {
        try {
            Kelas::destroy($id);
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
