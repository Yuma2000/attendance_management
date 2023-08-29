<?php


class Database{

    // データベースへの接続処理
    function connect(){

        $db_host = $_ENV['DB_HOST'];
        $db_user = $_ENV['DB_USER'];
        $db_pass = $_ENV['DB_PASSWORD'];
        $db_name = $_ENV['DB_NAME'];
        $db_type = $_ENV['DB_TYPE'];
        $dsn = "$db_type:host=$db_host;dbname=$db_name;charset=utf8mb4";

        try{
            //MySQLに接続
            $pdo = new PDO($dsn, $db_user, $db_pass);
            $pdo -> setAttribute(PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION);
    
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            // $pdo -> query('SET NAMES UTF8MB4');
            return $pdo;
        }catch (PDOException $e) {
            exit($e->getMessage());

        }
    
    }


    //出欠の登録
    function record($child_id,$status,$absence_reason){
        $currentDate = date("Y-m-d");//日付の取得
        //$randomNumber = rand(1, 20); // 1から20までのランダムな数値を生成

        $pdo = $this->connect();
        $sql = "INSERT INTO records (child_id, date, status, absence_reason) 
        VALUES (:child_id, :currentDate, :status, :absence_reason)";
    
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':child_id', $child_id, PDO::PARAM_INT);//値を実際に挿入する．
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':absence_reason', $absence_reason, PDO::PARAM_STR);
        $stmt->bindParam(':currentDate', $currentDate,PDO::PARAM_STR);
        //$stmt->bindParam(':randomNumber', $randomNumber, PDO::PARAM_INT);
        $stmt->execute();
        
        return 0;
    }
  
    //recordsテーブルのデータを全取得＆recordsテーブルのchild_idからchildrenテーブルのnameカラムの値を取得する（出席者用）
    function all_records_present(){
        $pdo = $this->connect();
        // $sql = 'SELECT records.*, children.name AS child_name FROM records
        //         INNER JOIN children ON records.child_id = children.id';
        $sql = 'SELECT records.*, children.name AS child_name FROM records
                INNER JOIN children ON records.child_id = children.id WHERE records.status = 1';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $recordsWithPresentChildNames = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $recordsWithPresentChildNames;
    }

    

    //recordsテーブルのデータを全取得＆recordsテーブルのchild_idからchildrenテーブルのnameカラムの値を取得する（欠席者用）
    function all_records_absent(){
        $pdo = $this->connect();
        $sql = 'SELECT records.*, children.name AS child_name FROM records
                INNER JOIN children ON records.child_id = children.id WHERE records.status = 2';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $recordsWithAbsentChildNames = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $recordsWithAbsentChildNames;
    }

    // recordsテーブルのchild_idからその園児の出欠記録データとchildrenテーブルのnameカラムの値を取得
    function find($id){
        $dbh = $this->connect();
        
        $sql = 'SELECT records.*, children.name AS child_name FROM records
                INNER JOIN children ON records.child_id = children.id
                WHERE records.child_id = ?';
        
        $stmt = $dbh->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }

    //childrenテーブルのデータを全取得
    function children(){
        $pdo = $this->connect();
        $sql = 'SELECT * FROM children';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $childrenNames = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $childrenNames;
    }

    
}

?>