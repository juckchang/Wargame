<?php session_start(); ?>
<?php require_once __DIR__ . '/Libs/db.php'; ?>
<?php require_once __DIR__ . '/Libs/util.php'; ?>
<?php define('__MAIN__', 1); ?>
<?php error_reporting(E_ALL); ini_set('display_errors', '1'); ?>

<?php
    $data = json_decode(file_get_contents('php://input'), true);
    $routes = ['login', 'logout', 'register', 'rank', 'chall'];
    if(empty($_GET['url'])){
        require_once __DIR__ . '/routes/main.php';
    }else if(in_array($_GET['url'], $routes)){
        require_once __DIR__ . '/routes/' . $_GET['url'] . '.php';
    }else{
        require_once __DIR__ . '/routes/404.php';
    }
?>
        