<?php
class Controller
{
    public function model($model)
    {
        require_once '../app/models/' . $model . '.php';
        return new $model();
    }

    public function view($view, $data = [])
    {
        self::renderView($view, $data);
    }

    public static function renderView($view, $data = [])
    {
        ob_start();
        require '../app/views/' . $view . '.php';
        $content = ob_get_clean();

        require '../app/views/layout/materlayout.php';
    }
}
