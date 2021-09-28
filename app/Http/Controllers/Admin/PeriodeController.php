<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\MataPelajaran;
use App\Models\Periode;

class PeriodeController extends CustomController
{
    public function store()
    {
        try {
            $name = $this->postField('name');
            $data = [
                'nama' => $name
            ];
            $this->insert(Periode::class, $data);
            return $this->jsonResponse('success', 200);
        }catch (\Exception $e){
            return $this->jsonResponse($e->getMessage(), 200);
        }
    }
}
