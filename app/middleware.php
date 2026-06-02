<?php
    class middleware {
        function checklogin() {
            $publicPages = [
                '/auth/login'
            ];
            if(!isset($_SESSION['username']) && !in_array($_SERVER['REQUEST_URI'], $publicPages)) {
                header('Location: /auth/login');
                exit();
            }
        }
    }
?>
