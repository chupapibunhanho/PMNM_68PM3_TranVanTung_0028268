<?php
echo "Hello, World!";
require_once '../app/core/App.php';


$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$arr = explode('/', trim($url, '/'));
print_r($arr);
$app = new App();
?>