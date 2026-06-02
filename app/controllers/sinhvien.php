<?php
class sinhvien extends Controller
{
    public function index()
    {
        $sinhvienModel = $this->model('sinhvienModel');
        $sinhviens = $sinhvienModel->getAllSinhVien();

        $this->view('sinhvien/index', [
            'sinhviens' => $sinhviens,
            'dbError' => $sinhvienModel->isConnected() ? '' : 'Chua ket noi duoc database. Hay kiem tra lai username/password trong connectDB.php.',
        ]);
    }

    public function create()
    {
        $sinhvienModel = $this->model('sinhvienModel');
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($sinhvienModel->createSinhVien($_POST)) {
                header('Location: ../sinhvien/index');
                exit();
            }

            $errors[] = 'Khong the them sinh vien. Vui long kiem tra lai du lieu.';
        }

        $this->view('sinhvien/create', [
            'columns' => $sinhvienModel->getEditableColumns(),
            'errors' => $errors,
        ]);
    }
}
