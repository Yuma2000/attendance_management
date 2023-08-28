<?php

class Database{

    // function connect(){
    //             $dsn = 'mysql:dbname=attendance_management;host=localhost';
    //             $user = '';
    //             $password = '';

    //     try{
    //         $dbh = new PDO($dsn,$user,$password);
    //         $dbh -> query('SET NAMES UTF8MB4');
    //         return $dbh;
    //     }catch(Exception $e){
    //         exit($e->getMessage());
    //     }
    // }

    function try() {
 
        // 接続処理
        $db_user = "sample"; //ユーザー名
        $db_pass = "password"; //パスワード
        $db_host = "localhost"; //ホスト名
        $db_name = "attendancedb"; //データベース名
        $db_type = "mysql"; //データベースの種類

        //DSN（接続のための決まった情報を決まった順序に組み立てた文字列のこと）の組み立て
        $dsn = "$db_type:host=$db_host;dbname=$db_name;charset=utf8";
        try{
            //MySQLに接続
            $pdo = new PDO($dsn, $db_user, $db_pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION);
    
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            //print "接続しました...<br>";
        }catch(PDOException $Exception){
            die('接続エラー:'.$Exception->getMessage());
        }
 
        // SELECT文を発行
        $sql = "SELECT * FROM inputtable";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(); // 全てのレコードを取得
 
        // 接続切断あ
        $pdo = null;
 
    } function catch (PDOException $e) {
        print $e->getMessage() . "<br/>";
        die();
    }

}

?>