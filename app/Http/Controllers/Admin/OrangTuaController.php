<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Guru;
use App\Models\OrangTua;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OrangTuaController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = OrangTua::with('user')->get();
        return view('main.pengguna.orang-tua.index')->with(['data' => $data]);
    }

    public function addPage()
    {
        return view('main.pengguna.orang-tua.add');
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            $username = $this->postField('username');
            $name = $this->postField('name');
            $password = Hash::make($this->postField('password'));
            $data = [
                'username' => $username,
                'password' => $password,
                'role' => 'orangtua',
            ];
            $user = $this->insert(User::class, $data);
            $data_orang_tua = [
                'nama' => $name,
                'user_id' => $user->id,
                'alamat' => $this->postField('alamat'),
                'no_hp' => $this->postField('no_hp')
            ];
            $this->insert(OrangTua::class, $data_orang_tua);
            DB::commit();
            return redirect()->back()->with(['success' => 'Berhasil Menambahkan Data Orang Tua...']);
        } catch (\Exception $e) {
            DB::rollBack();
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
