<?php
    define('WEBROOT', '/app');
    
    function hashing($data){
        return hash('sha256', 'FIr5t-s4lt__'.$data.'______l4st___s4l7');
    }

    function insertUser($id, $pw, $comment){
        $res = query('insert into users value(:id, :pw, :comment, now(), 0);', [
            ':id' => $id,
            ':pw' => hashing($pw),
            ':comment' => $comment
        ]);
        return $res['ret'];
    }

    function loginUser($id, $pw){
        $res = query('select id from users where id=:id and pw=:pw;', [
            ':id' => $id,
            ':pw' => hashing($pw)
        ]);
        return $res;
    }

    function checkLogin(){
        return isset($_SESSION['id']);
    }

    function getUsers(){
        $res = query_all('select id from users;');
        return $res['all'];
    }

    function getChalls($category){
        $res = query_all('select * from challs where visable=1 and category=:category;',[
            ':category' => $category
        ]);
        return $res['all'];
    }

    function getCategorys(){
        $res = query_all('select distinct category from challs;');
        return $res['all'];
    }

    function getUploads($no){
        $res = query_all('select path from uploads where no=:no;', [
            ':no' => $no
        ]);
        return $res['all'];
    }

    function getSolvers($no){
        $res = query('select count(*) as cnt from solves where no=:no;',[
            ':no' => $no
        ]);
        return intval($res['val']['cnt']);
    }

    function checkSolved($no){
        $res = query('select count(*) as cnt from solves where id=:id and no=:no;',[
            ':id' => $_SESSION['id'],
            ':no' => $no
        ]);
        return intval($res['val']['cnt']) == 0 ? 1 : 0; // no solve => 1
    }

    function checkFlag($no, $flag){
        $res = query('select count(*) as cnt from challs where no=:no and flag=:flag;', [
            ':no' => $no,
            ':flag' => $flag
        ]);
        return intval($res['val']['cnt']) == 0 ? 0 : 1; // correct => 1
    }

    function insertSubmission($check, $no, $flag){
        $res = query('insert into submissions value(0, :id, :no, :ip, :flag, now(), :correct);', [
            ':id' => $_SESSION['id'],
            ':no' => $no,
            ':ip' => $_SERVER['REMOTE_ADDR'],
            ':flag' => $flag,
            ':correct' => $check
        ]);
        return $res['ret'];
    }
    
    function insertSolve($no, $flag){
        $res = query('insert into solves value(0, :id, :no, :flag, now());', [
            ':id' => $_SESSION['id'],
            ':no' => $no,
            ':flag' => $flag
        ]);
        return $res['ret'];
    }

    function updateUser(){
        $res = query('update users set last_solves=unix_timestamp() where id=:id', [
            ':id' => $_SESSION['id']
        ]);
        return $res['ret'];
    }
?>