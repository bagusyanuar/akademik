<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
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
        return view('main.pengguna.siswa.add');
    }

    public function store()
    {
        try {
            $name = $this->postField('name');
            $tgl_lahir = $this->postField('tgl_lahir');
            $alamat = $this->postField('alamat');
            $orang_tua = $this->postField('orang_tua');
            $kelas = $this->postField('kelas');
            $data = [
                'nama' => $name,
                'tgl_lahir' => $tgl_lahir,
                'alamat' => $alamat,
                'orang_tua_id' => $orang_tua !== '' ? $orang_tua : null,
                'kelas_id' => $kelas !== '' ? $kelas : null,
            ];
            $this->insert(Siswa::class, $data);
            return redirect()->back()->with(['success' => 'Berhasil Menambahkan Data Siswa...']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['failed' => 'Terjadi Kesalahan...']);

        }
    }

    public function editPage($id)
    {
        $data = OrangTua::with('user')->where('id', $id)->firstOrFail();
        return view('main.pengguna.orang-tua.edit')->with(['data' => $data]);
    }

    public function patch()
    {
        DB::beginTransaction();
        try {
            $id = $this->postField('id');
            $username = $this->postField('username');
            $name = $this->postField('name');
            $password = $this->postField('password');
            $orang_tua = OrangTua::find($id);
            $orang_tua->nama = $name;
            $orang_tua->no_hp = $this->postField('no_hp');
            $orang_tua->alamat = $this->postField('alamat');
            $orang_tua->save();

            $user = User::find($orang_tua->user_id);
            $user->username = $username;
            if ($password !== '') {
                $user->password = Hash::make($password);
            }
            $user->save();
            DB::commit();
            return redirect('/orang-tua');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['failed' => 'Terjadi Kesalahan...' . $e]);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json([
                    'msg' => 'Guru Tidak Di Temukan',
                    'code' => 202
                ]);
            }
            $user->orangTua()->delete();
            $user->delete();
            DB::commit();
            return response()->json([
                'msg' => 'success',
                'code' => 200
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'msg' => 'Terjadi Kesalahan' . $e,
                'code' => 500
            ]);
        }
    }
}
