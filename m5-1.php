<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_5-1</title>
</head>
<body>
<?php
// DB接続設定
            $dsn = 'mysql:dbname=tb******db;host=localhost';
            $user = 'tb-******';
            $password = 'password';
            $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
//テーブル作成    
            $sql = "CREATE TABLE IF NOT EXISTS m501"
            ." ("
            . "id INT AUTO_INCREMENT PRIMARY KEY,"
            . "name char(32),"
            . "comment TEXT,"
            . "date TEXT,"
            . "password TEXT"
            .");";
            $stmt = $pdo->query($sql);
//データを入力

//新規投稿
//名前とコメントに数値が入っていた場合
            if (!empty($_POST["name"]) && !empty($_POST["str"])){
    //新規        
            $sql = $pdo -> prepare("INSERT INTO m501 (name, comment, date, password) VALUES (:name, :comment,:date,:password)");
            $sql -> bindParam(':name', $name, PDO::PARAM_STR);
            $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
            $sql -> bindParam(':date', $date, PDO::PARAM_STR);
            $sql -> bindParam(':password', $password, PDO::PARAM_STR);
            
            $name = ($_POST["name"]);
            $comment = ($_POST["str"]); 
            $date = date("Y/m/d H:i:s");
            $password = ($_POST["pass"]);
            
            if(is_numeric($_POST["num3"])){
            
            $id = $_POST["num3"]; //変更する投稿番号
            $name =  ($_POST["name"]);
            $comment =  ($_POST["str"]); 
            $date = date("Y/m/d H:i:s");
            
            $sql = 'UPDATE m501 SET name=:name,comment=:comment,date=:date WHERE id=:id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':date', $date, PDO::PARAM_INT);
            $stmt->execute(); 
        }
            else{
            $sql -> execute();
        }
//抽出し、表示
            $sql = 'SELECT * FROM m501';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row){
                //$rowの中にはテーブルのカラム名が入る
                echo $row['id'].',';
                echo $row['name'].',';
                echo $row['comment'].',';
                echo $row['date'].',';
                echo $row['password'].'<br>';
                
            echo "<hr>";
            }
            }
            
//削除
    if(!empty($_POST["del"]) && !empty($_POST["pass1"])){
        $sql = 'SELECT * FROM m501';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        
            foreach ($results as $row){
            if ($row['password']==$_POST["pass1"]){
            //$rowの中にはテーブルのカラム名が入る
            $id = $_POST["del"];
            $sql = 'delete from m501 where id=:id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            echo "";
        }    
    }
            $sql = 'SELECT * FROM m501';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row){
                //$rowの中にはテーブルのカラム名が入る
                echo $row['id'].',';
                echo $row['name'].',';
                echo $row['comment'].',';
                echo $row['date'].',';
                echo $row['password'].'<br>';
                
            echo "<hr>";
        }    
}
//編集
    //編集番号と編集パスワードが空でない時
            if(!empty($_POST["num2"])){
        $sql = 'SELECT * FROM m501';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();   
        
        foreach ($results as $row){
            //$rowの中にはテーブルのカラム名が入る
            if($row["id"] == $_POST["num2"]){
            if ($row['password']==$_POST["pass2"]){
            $tt=$row;
        }
        }
    }
        }
        

?>
    
<form action="" method="post">
    <input type="text" name="name" value="<?php if(!empty($tt)) {echo $tt["name"];} ?>"placeholder="名前" >
    <input type="text" name="str"  value="<?php if(!empty($tt)) {echo $tt["comment"];} ?>"placeholder="コメント">
    <input type="text" name="pass" placeholder="パスワード">
    <input type="hidden" name="num3" value="<?php echo $tt["id"] ?>">
    <input type="submit" name="submit" >
</form>

<form action="" method="post">
    <input type="number" name="del" placeholder="削除対象番号">
    <input type="text" name="pass1" placeholder="パスワード">    
    <input type="submit" name="submit" value="削除">
</form>

<form action="" method="post">
    <input type="number" name="num2" placeholder="編集対象番号">
    <input type="text" name="pass2" placeholder="パスワード">    
    <input type="submit" name="submit" value="編集">
</form>

</body>
</html>