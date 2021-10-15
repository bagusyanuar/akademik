<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Admin;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GuruController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = Guru::with('user')->get();
        return view('main.pengguna.guru.index')->with(['data' => $data]);
    }

    public function addPage()
    {
        return view('main.pengguna.guru.add');
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
                'role' => 'admin',
            ];
            $user = $this->insert(User::class, $data);
            $data_guru = [
                'nama' => $name,
                'user_id' => $user->id
            ];
            $this->insert(Guru::class, $data_guru);
            DB::commit();
            return redirect()->back()->with(['success' => 'Berhasil Menambahkan Data Guru...']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['failed' => 'Terjadi Kesalahan...']);

        }
    }

    public function editPage($id)
    {
        $data = Guru::with('user')->where('id', $id)->firstOrFail();
        return view('main.pengguna.guru.edit')->with(['data' => $data]);
    }

    public function patch()
    {
        DB::beginTransaction();
        try {
            $id = $this->postField('id');
            $username = $this->postField('username');
            $name = $this->postField('name');
            $password = $this->postField('password');
            $guru = Guru::find($id);
            $guru->nama = $name;
            $guru->save();

            $user = User::find($guru->user_id);
            $user->username = $username;
            if ($password !== '') {
                $user->password = Hash::make($password);
            }
            $user->save();
            DB::commit();
            return redirect('/guru');
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
            $user->guru()->delete();
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
