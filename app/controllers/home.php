<?php
require_once '../app/models/sinhvienModel.php';

class home
{
    public function index()
    {
        $model = new sinhvienModel();
        $danhSachSinhVien = $model->getAllSinhVien();
        Controller::renderView('sinhvien/home/index', [
            'title' => 'Danh sach sinh vien',
            'danhSachSinhVien' => $danhSachSinhVien,
        ]);
    }
    
    public function about(){
        Controller::renderView('sinhvien/about', [
            'title' => 'Gioi thieu',
        ]);
    }
    
    public function login(){
        Controller::renderView('sinhvien/login', [
            'title' => 'Dang nhap',
        ]);
    }

}
