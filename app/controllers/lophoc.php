<?php
class lophoc extends Controller
{
    public function index()
    {
        $lophocModel = $this->model('lophocModel');
        $limit = 5;
        $filters = [
            'malop' => trim($_GET['malop'] ?? ''),
        ];
        
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $page = max($page, 1);
        $totalLopHoc = $lophocModel->count($filters);
        $totalPages = max((int) ceil($totalLopHoc / $limit), 1);

        if ($page > $totalPages) {
            $page = $totalPages;
        }

        $offset = ($page - 1) * $limit;
        $lophocs = $lophocModel->paging($limit, $offset, $filters);

        $this->view('lophoc/index', [
            'lophocs' => $lophocs,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'filters' => $filters,
            'dbError' => $lophocModel->isConnected() ? '' : 'Chua ket noi duoc database. Hay kiem tra lai username/password trong connectDB.php.',
        ]);
    }

    public function create()
    {
        $lophocModel = $this->model('lophocModel');
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($lophocModel->create($_POST)) {
                $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
                header('Location: ' . $basePath . '/lophoc/index');
                exit();
            }

            $errors[] = 'Khong the them lop hoc. Vui long kiem tra lai ma lop.';
        }

        $this->view('lophoc/create', [
            'errors' => $errors,
        ]);
    }

    public function update()
    {
        $lophocModel = $this->model('lophocModel');
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';

            if ($id === '' || !$lophocModel->update($id, $_POST)) {
                $error = '&error=update_lophoc';
            }
        }

        $page = isset($_POST['page']) ? max((int) $_POST['page'], 1) : 1;
        $malop = trim($_POST['search_malop'] ?? '');
        $filterQuery = $malop !== '' ? '&malop=' . urlencode($malop) : '';
        $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
        
        $redirectUrl = $basePath . '/lophoc/index?page=' . $page . $filterQuery . $error;
        header('Location: ' . $redirectUrl);
        exit();
    }

    public function delete()
    {
        $lophocModel = $this->model('lophocModel');
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';

            if ($id === '' || !$lophocModel->delete($id)) {
                $error = '&error=delete_lophoc';
            }
        }

        $page = isset($_POST['page']) ? max((int) $_POST['page'], 1) : 1;
        $malop = trim($_POST['search_malop'] ?? '');
        $filterQuery = $malop !== '' ? '&malop=' . urlencode($malop) : '';
        $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
        
        $redirectUrl = $basePath . '/lophoc/index?page=' . $page . $filterQuery . $error;
        header('Location: ' . $redirectUrl);
        exit();
    }
}
