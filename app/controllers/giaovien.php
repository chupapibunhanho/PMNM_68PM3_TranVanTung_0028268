<?php
class giaovien extends Controller
{
    public function index()
    {
        $giaovienModel = $this->model('giaovienModel');
        $limit = 5;
        $filters = [
            'mgv' => trim($_GET['mgv'] ?? ''),
            'hoten' => trim($_GET['hoten'] ?? ''),
        ];
        
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $page = max($page, 1);
        $totalGiaoVien = $giaovienModel->count($filters);
        $totalPages = max((int) ceil($totalGiaoVien / $limit), 1);

        if ($page > $totalPages) {
            $page = $totalPages;
        }

        $offset = ($page - 1) * $limit;
        $giaoviens = $giaovienModel->paging($limit, $offset, $filters);

        $this->view('giaovien/index', [
            'giaoviens' => $giaoviens,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'filters' => $filters,
            'dbError' => $giaovienModel->isConnected() ? '' : 'Chua ket noi duoc database. Hay kiem tra lai username/password trong connectDB.php.',
        ]);
    }

    public function create()
    {
        $giaovienModel = $this->model('giaovienModel');
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($giaovienModel->create($_POST)) {
                $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
                header('Location: ' . $basePath . '/giaovien/index');
                exit();
            }

            $errors[] = 'Khong the them giao vien. Vui long kiem tra lai ma giang vien.';
        }

        $this->view('giaovien/create', [
            'errors' => $errors,
        ]);
    }

    public function update()
    {
        $giaovienModel = $this->model('giaovienModel');
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';

            if ($id === '' || !$giaovienModel->update($id, $_POST)) {
                $error = '&error=update_giaovien';
            }
        }

        $page = isset($_POST['page']) ? max((int) $_POST['page'], 1) : 1;
        $mgv = trim($_POST['search_mgv'] ?? '');
        $hoten = trim($_POST['search_hoten'] ?? '');
        $filterQuery = '';
        if ($mgv !== '') $filterQuery .= '&mgv=' . urlencode($mgv);
        if ($hoten !== '') $filterQuery .= '&hoten=' . urlencode($hoten);
        
        $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
        
        $redirectUrl = $basePath . '/giaovien/index?page=' . $page . $filterQuery . $error;
        header('Location: ' . $redirectUrl);
        exit();
    }

    public function delete()
    {
        $giaovienModel = $this->model('giaovienModel');
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';

            if ($id === '' || !$giaovienModel->delete($id)) {
                $error = '&error=delete_giaovien';
            }
        }

        $page = isset($_POST['page']) ? max((int) $_POST['page'], 1) : 1;
        $mgv = trim($_POST['search_mgv'] ?? '');
        $hoten = trim($_POST['search_hoten'] ?? '');
        $filterQuery = '';
        if ($mgv !== '') $filterQuery .= '&mgv=' . urlencode($mgv);
        if ($hoten !== '') $filterQuery .= '&hoten=' . urlencode($hoten);
        
        $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
        
        $redirectUrl = $basePath . '/giaovien/index?page=' . $page . $filterQuery . $error;
        header('Location: ' . $redirectUrl);
        exit();
    }
}
