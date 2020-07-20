<?php
	error_reporting(0);
function query($query, $param=[]){
        $dsn = 'mysql:host=localhost;port=3306;dbname=c2w2m2;charset=utf8';
        try{
            $db = new PDO($dsn, 'app', '[reject]');
            $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            $db->exec('set sql_mode="STRICT_TRANS_TABLES"');

            $state = $db->prepare($query);
            $state->setFetchMode(PDO::FETCH_ASSOC);

            $result = array();
            $result['ret'] = $state->execute($param);
            $result['val'] = $state->fetch();
            $db = null;

            return $result;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    function query_all($query, $param=[]){
        $dsn = 'mysql:host=localhost;port=3306;dbname=c2w2m2;charset=utf8';
        try{
            $db = new PDO($dsn, 'app', '[reject]');
            $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            $db->exec('set sql_mode="STRICT_TRANS_TABLES"');

            $state = $db->prepare($query);
            $state->setFetchMode(PDO::FETCH_ASSOC);

            $result = array();
            $result['ret'] = $state->execute($param);
            $result['all'] = $state->fetchAll();
            $db = null;

            return $result;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
?>

