<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Admin;
use App\Models\Kelas;
use App\Models\KelasSiswa;
use App\Models\Nilai;
use App\Models\Periode;
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

    public function raportNilai() {

        $kelas = Kelas::all();
        $periode = Periode::orderBy('nama', 'DESC')->get();
        return view('main.raport.admin.raport_nilai')->with([
            'kelas' => $kelas,
            'periode' => $periode,
        ]);
    }

    public function dataRaportNilai() {
        try {
            $periode = $this->field('periode');
            $semester = $this->field('semester');
            $kelas = $this->field('kelas');

            $siswa = KelasSiswa::with(['siswa', 'kelas.pelajaran.mataPelajaran', 'kelas.pelajaran' => function ($query) use ($periode, $semester) {
                return $query->where('periode_id', '=', $periode)
                    ->where('semester', '=', $semester);
            }
            ])
                ->where('kelas_id', $kelas)
                ->where('periode_id', $periode)
                ->get();
            $results = [];
            foreach ($siswa as $v) {
                $tmp['id'] = $v->id;
                $tmp['nama'] = $v->siswa->nama;
                $tmp['kelas'] = $v->kelas->nama;
                $tmp['pelajaran'] = [];

                foreach ($v->kelas->pelajaran as $key => $pelajaran) {
                    $tmpPelajaran['nama'] = $pelajaran->mataPelajaran->nama;
                    $tmpPelajaran['nilai'] = 0;
                    $nilai = Nilai::where('pelajaran_kelas_id', '=', $pelajaran->id)
                        ->where('kelas_siswa_id', '=', $v->id)->first();
                    if ($nilai) {
                        $tmpPelajaran['nilai'] = $nilai->nilai;
                    }
                    array_push($tmp['pelajaran'], $tmpPelajaran);
                }

                $tmp['rata_rata'] = count($tmp['pelajaran']) > 0 ? array_sum($tmpAve = array_column($tmp['pelajaran'], 'nilai')) / count($tmp['pelajaran']) : 0;
                array_push($results, $tmp);
            }
            return $this->basicDataTables($results);
        }catch (\Exception $e) {
            return $this->basicDataTables([]);
        }
    }

    public function raportAbsen() {
        $kelas = Kelas::all();
        $periode = Periode::orderBy('nama', 'DESC')->get();
        return view('main.raport.admin.raport_absen')->with([
            'kelas' => $kelas,
            'periode' => $periode,
        ]);
    }

}
