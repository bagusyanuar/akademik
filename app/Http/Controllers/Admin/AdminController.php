<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = Admin::with('user')->get();
        return view('main.pengguna.admin.index')->with(['data' => $data]);
    }

    public function addPage()
    {
        return view('main.pengguna.admin.add');
    }

    public function editPage($id)
    {
        $data = Admin::with('user')->where('id', $id)->firstOrFail();
        return view('main.pengguna.admin.edit')->with(['data' => $data]);
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
            $data_admin = [
                'nama' => $name,
                'user_id' => $user->id
            ];
            $this->insert(Admin::class, $data_admin);
            DB::commit();
            return redirect()->back()->with(['success' => 'Berhasil Menambahkan Data Admin...']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['failed' => 'Terjadi Kesalahan...']);

        }
    }

    public function patch()
    {
        DB::beginTransaction();
        try {
            $id = $this->postField('id');
            $username = $this->postField('username');
            $name = $this->postField('name');
            $password = $this->postField('password');
            $admin = Admin::find($id);
            $admin->nama = $name;
            $admin->save();

            $user = User::find($admin->user_id);
            $user->username = $username;
            if ($password !== '') {
                $user->password = Hash::make($password);
            }
            $user->save();
            DB::commit();
            return redirect('/admin');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['failed' => 'Terjadi Kesalahan...' . $e]);
        }
    }
}
