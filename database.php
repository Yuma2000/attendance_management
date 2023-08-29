<?php


class Database{

    // データベースへの接続処理
    public function connect(){

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

    /**
     * recordsテーブルのデータを全取得＆recordsテーブルのchild_idからchildrenテーブルのnameカラムの値を取得する（出席者用）
     */
    public function all_records_present(){
        $pdo = $this->connect();
        $sql = 'SELECT records.*, children.name AS child_name FROM records
                INNER JOIN children ON records.child_id = children.id WHERE records.status = 1';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $recordsWithPresentChildNames = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $recordsWithPresentChildNames;
    }

    /**
     * recordsテーブルのデータを全取得＆recordsテーブルのchild_idからchildrenテーブルのnameカラムの値を取得する（欠席者用）
     */
    public function all_records_absent(){
        $pdo = $this->connect();
        $sql = 'SELECT records.*, children.name AS child_name FROM records
                INNER JOIN children ON records.child_id = children.id WHERE records.status = 2';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $recordsWithAbsentChildNames = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $recordsWithAbsentChildNames;
    }

    /**
     * recordsテーブルのchild_idからその園児の出欠記録データとchildrenテーブルのnameカラムの値を取得
     */
    public function find($id){
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
    public function children(){
        $pdo = $this->connect();
        $sql = 'SELECT id, name FROM children';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $childrenNames = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $childrenNames;
    }

    /**
     * 園児のIDから名前を取得する。
     *
     * @param int $id 園児のID
     * @return string|null 園児の名前、または該当する園児が存在しない場合はnull
     */
    public function getChildName($id)
    {
        try {
            $pdo = $this->connect();
            $sql = 'SELECT name FROM children WHERE id = :id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $name = $stmt->fetch();
            return $name[0];
        } catch (Throwable $e) {
            echo "エラーが発生しました。";
        }
    }
}
