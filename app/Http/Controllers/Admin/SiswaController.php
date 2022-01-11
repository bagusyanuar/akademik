<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Kelas;
use App\Models\OrangTua;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SiswaController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = Siswa::with('orangTua')->get();
        return view('main.pengguna.siswa.index')->with(['data' => $data]);
    }

    public function addPage()
    {
        $data_kelas = Kelas::all();
        $data_orang_tua = OrangTua::all();
        return view('main.pengguna.siswa.add')->with(['data_kelas' => $data_kelas, 'data_orang_tua' => $data_orang_tua]);
    }

    public function store()
    {
        try {
            $name = $this->postField('name');
            $tgl_lahir = $this->postField('tgl_lahir');
            $alamat = $this->postField('alamat');
            $orang_tua = $this->postField('orang_tua');
            $kelas = $this->postField('kelas');
            $nis = $this->postField('nis');
            $data = [
                'nis' => $nis,
                'nama' => $name,
                'tgl_lahir' => $tgl_lahir,
                'alamat' => $alamat,
                'orang_tua_id' => $orang_tua !== '' ? $orang_tua : null,
            ];
            $this->insert(Siswa::class, $data);
            return redirect()->back()->with(['success' => 'Berhasil Menambahkan Data Siswa...']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['failed' => 'Terjadi Kesalahan...']);

        }
    }

    public function editPage($id)
    {
        $data = Siswa::with(['orangTua.orangTua'])->where('id', $id)->firstOrFail();
//        return $data->toArray();
        $data_kelas = Kelas::all();
        $data_orang_tua = OrangTua::all();
        return view('main.pengguna.siswa.edit')->with(['data' => $data, 'data_orang_tua' => $data_orang_tua]);
    }

    public function patch()
    {
        try {
            $id = $this->postField('id');
            $siswa = Siswa::find($id);
            $name = $this->postField('name');
            $tgl_lahir = $this->postField('tgl_lahir');
            $alamat = $this->postField('alamat');
            $orang_tua = $this->postField('orang_tua') !== '' ? $this->postField('orang_tua') : null;

            $siswa->nama = $name;
            $siswa->tgl_lahir = $tgl_lahir;
            $siswa->alamat = $alamat;
            $siswa->orang_tua_id = $orang_tua;
            $siswa->save();
            return redirect('/siswa');
        } catch (\Exception $e) {
            return redirect()->back()->with(['failed' => 'Terjadi Kesalahan...' . $e]);
        }
    }

    public function destroy($id)
    {
        try {
            $siswa = Siswa::destroy($id);
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
