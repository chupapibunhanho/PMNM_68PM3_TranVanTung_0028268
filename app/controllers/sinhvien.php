<?php
class sinhvien extends Controller
{
    public function index()
    {
        $sinhvienModel = $this->model('sinhvienModel');
        $limit = 5;
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $page = max($page, 1);
        $totalSinhVien = $sinhvienModel->countSinhVien();
        $totalPages = max((int) ceil($totalSinhVien / $limit), 1);

        if ($page > $totalPages) {
            $page = $totalPages;
        }

        $offset = ($page - 1) * $limit;
        $sinhviens = $sinhvienModel->paging($limit, $offset);

        $this->view('sinhvien/index', [
            'sinhviens' => $sinhviens,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'primaryKey' => $sinhvienModel->getPrimaryKeyColumn(),
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

    public function delete()
    {
        $sinhvienModel = $this->model('sinhvienModel');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';

            if ($id !== '') {
                $sinhvienModel->deleteSinhVien($id);
            }
        }

        $page = isset($_POST['page']) ? max((int) $_POST['page'], 1) : 1;
        header('Location: ?url=sinhvien/index&page=' . $page);
        exit();
    }
}
