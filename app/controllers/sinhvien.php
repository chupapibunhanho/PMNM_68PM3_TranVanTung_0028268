<?php
class sinhvien extends Controller
{
    public function index()
    {
        $sinhvienModel = $this->model('sinhvienModel');
        $sinhviens = $sinhvienModel->getAllSinhVien();

        $this->view('sinhvien/index', ['sinhviens' => $sinhviens]);
    }

    public function create()
    {
        $this->view('sinhvien/create');
    }
}
