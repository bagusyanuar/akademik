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

    public function store()
    {
        try {
            $name = $this->postField('name');
            $data = [
                'nama' => $name
            ];
            $this->insert(MataPelajaran::class, $data);
            return $this->jsonResponse('success', 200);
        }catch (\Exception $e){
            return $this->jsonResponse($e->getMessage(), 200);
        }
    }
}
