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

            return $pdo;
        }catch (PDOException $e) {
            exit($e->getMessage());

        }
    }

    // recordsテーブルのデータの重複を調べる
    function isDuplicationRecord($child_id, $date){
        $pdo = $this -> connect();
        $sql = 'SELECT COUNT(*) FROM records WHERE child_id = :child_id AND date = :date';
        $stmt = $pdo -> prepare($sql);
        $stmt -> bindParam(':child_id', $child_id, PDO::PARAM_INT);
        $stmt -> bindParam(':date', $date, PDO::PARAM_STR);
        $stmt -> execute();
        $rowCount = $stmt -> fetchColumn();

        return $rowCount > 0; //行数が1以上ならtrue,該当する行がなければfalse
    }

    // 出欠の登録
    function record($input){
        $pdo = $this -> connect();
        $stmt = $pdo -> prepare('INSERT INTO records SET child_id=?, date=?, status=?, absence_reason=?');
        $stmt -> execute([$input['child_id'],$input['date'],$input['status'],$input['absence_reason']]);
    }
 
    // recordsテーブルのデータを全取得＆recordsテーブルのchild_idからchildrenテーブルのnameカラムの値を取得する（出席者用）
    public function all_records_present($class_name){ //$class_nameで特定のクラスの園児のみを抽出
        $pdo = $this->connect();
        $sql = 'SELECT records.*, children.name AS child_name, replies.content AS check_message, childminders.name AS minder_name FROM records
                INNER JOIN children ON records.child_id = children.id
                LEFT JOIN replies ON records.id = replies.record_id
                LEFT JOIN childminders ON replies.minder_id = childminders.id
                WHERE records.status = 1 AND records.date = CURDATE() AND children.class = ?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$class_name]);
        $recordsWithPresentChildNames = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $recordsWithPresentChildNames;
    }

    // recordsテーブルのデータを全取得＆recordsテーブルのchild_idからchildrenテーブルのnameカラムの値を取得する（欠席者用）
    public function all_records_absent($class_name){
        $pdo = $this->connect();
        $sql = 'SELECT records.*, children.id AS child_id, children.name AS child_name
                FROM records
                INNER JOIN children ON records.child_id = children.id 
                WHERE records.status = 2 AND records.date = CURDATE() AND children.class = ?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$class_name]);
        $recordsWithAbsentChildNames = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $recordsWithAbsentChildNames;
    }
  
    /* （未提出者を抽出する） */
    public function all_records_yet($class_name){
        $currentDate = date("Y-m-d");//日付の取得
        $pdo = $this->connect();
        $sql = 'SELECT children.id AS child_id, children.name AS child_name 
                FROM children 
                WHERE children.class = ? AND NOT EXISTS 
                (
                    SELECT 1
                    FROM records yet
                    WHERE yet.child_id = children.id AND yet.date = CURDATE()
                )';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$class_name]);
        $childrenWithoutRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $childrenWithoutRecords;
    }

    /**
     * 遅刻者のレコードを抽出して返す。
     */
    public function all_records_late($class_name)
    {
        $currentDate = date("Y-m-d");
        $pdo = $this->connect();
        $sql = 'SELECT records.*, children.id AS child_id, children.name AS child_name
                FROM records
                INNER JOIN children ON records.child_id = children.id 
                WHERE records.status = 3 AND records.date = CURDATE() AND children.class = ?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$class_name]);
        $childrenWithoutRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $childrenWithoutRecords;
    }

    // recordsテーブルのchild_idからその園児の出欠記録データとchildrenテーブルのnameカラムの値を取得
    public function find($id){
        $dbh = $this->connect();
        $sql = 'SELECT records.*, children.name AS child_name, replies.content AS reply_content, childminders.name AS childminder_name, children.class AS child_class
                FROM records
                INNER JOIN children ON records.child_id = children.id
                LEFT JOIN replies ON records.id = replies.record_id
                LEFT JOIN childminders ON replies.minder_id = childminders.id
                WHERE records.child_id = ? ORDER BY records.date DESC';
        $stmt = $dbh->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }

    // 指定された年と月に対応する、child_idの園児の出欠記録データと関連する情報を取得
    public function findMonthlyRecords($child_id, $year, $month){
        $dbh = $this->connect();
        $sql = 'SELECT records.*, children.name AS child_name, replies.content AS reply_content, childminders.name AS childminder_name
                FROM records
                INNER JOIN children ON records.child_id = children.id
                LEFT JOIN replies ON records.id = replies.record_id
                LEFT JOIN childminders ON replies.minder_id = childminders.id
                WHERE records.child_id = ? AND YEAR(records.date) = ? AND MONTH(records.date) = ?
                ORDER BY records.date DESC'; //日付が最新の順に表示
        $stmt = $dbh->prepare($sql);
        $stmt->execute([$child_id, $year, $month]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    //recordsテーブルの特定のidのデータのみ取得
    function find_record($record_id){
        $dbh = $this -> connect();
        $sql = 'SELECT records.*, children.name AS child_name, replies.content AS reply_content, replies.minder_id AS minder_id, children.id AS child_id, children.class AS child_class, replies.id AS reply_id
                FROM records 
                INNER JOIN children ON records.child_id = children.id
                LEFT JOIN replies ON records.id = replies.record_id
                WHERE records.id = ?';
        $stmt = $dbh -> prepare($sql);
        $stmt -> execute([$record_id]);
        $result = $stmt -> fetch(PDO::FETCH_ASSOC);
    
        return $result;
    }

    //返信コメントの新規作成
    function store_reply($input){
        $dbh = $this -> connect();
        $stmt = $dbh -> prepare('INSERT INTO replies SET record_id=?,content=?,minder_id=?');
        $stmt -> execute([$input['record_id'],$input['reply_content'],$input['minder']]);
    }

    //返信内容の更新処理
    function update_reply($input){
        $dbh = $this ->connect();
        $stmt = $dbh -> prepare('UPDATE replies SET record_id=?,content=?,minder_id=? WHERE id=?');
        $stmt -> execute([$input['record_id'],$input['reply_content'],$input['minder'],$input['id']]);
    }


    //childrenテーブルのデータを全取得
    function children(){
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
    public function getChildName($id){
        try {
            $pdo = $this->connect();
            $sql = 'SELECT name, class FROM children WHERE id = :id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $childData = $stmt->fetch(PDO::FETCH_ASSOC);
            return $childData;
        } catch (Throwable $e) {
            echo "エラーが発生しました。";
        }
    }

    function check($input){
        $pdo = $this -> connect();
        $stmt = $pdo -> prepare('INSERT INTO replies SET content=?, record_id=?, minder_id=?');
        $stmt -> execute([$input['check_message'], (int)$input['record_id'], (int)$input['minder_id']]);
    }
}

