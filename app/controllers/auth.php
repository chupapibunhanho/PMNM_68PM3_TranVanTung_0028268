<?php
session_start();
class auth {
    protected $user = [
            "lxh"=>"lxh1",
            "admin"=>"123"
    ];

    public function login() {
        if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if(isset($this->user[$username]) && $this->user[$username] == $password) {
                $_SESSION['username'] = $username;
                header("Location: ../sinhvien/index");
                exit();
            } else {
                header('Location: login');
                exit();
            }
        }

        require_once '../app/views/sinhvien/login.php';
    }

    public function logout()
    {
        session_destroy();

        if (isset($_COOKIE['username'])) {
            setcookie('username', '', time() - 3600, '/');
        }

        if (isset($_COOKIE['password'])) {
            setcookie('password', '', time() - 3600, '/');
        }

        header('Location: login');
        exit();
    }
}
