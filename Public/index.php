<?php
require_once '../app/core/App.php';

if (!isset($_GET['url'])) {
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
    $_GET['url'] = trim($path, '/');
}

$app = new App();
?>
