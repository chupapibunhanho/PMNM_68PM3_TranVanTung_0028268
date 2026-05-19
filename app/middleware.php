<?php
require_once '../app/core/App.php';
    class middleware {
        function checklogin() {
            $publicPages = [
                '/QLSV/public/home/login',
                '/QLSV/public/auth/login'
            ];
            if(!isset($_SESSION['username']) && !in_array($_SERVER['REQUEST_URI'], $publicPages)) {
                header('Location: /QLSV/public/home/login');
                exit();
            }
        }
    }
?>