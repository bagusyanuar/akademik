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
        return view('main.pengguna.admin.index');
    }

    public function addPage()
    {
        return view('main.pengguna.admin.add');
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
                'name' => $name,
                'user_id' => $user->id
            ];
            $this->insert(Admin::class, $data_admin);
            DB::commit();
            return redirect()->back();
        }catch (\Exception $e){
            DB::rollBack();
            return redirect()->back();

        }

    }
}
