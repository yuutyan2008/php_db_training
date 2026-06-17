<?php
require_once 'functions.php';
// echo $_GET['id'];
if (empty($_GET['id'])) {
    echo "idを指定してください";
    exit;
}
if (!preg_match('/\A\d{1,11}+\z/u', $_GET['id'])) {
    echo "idが正しくありません";
    exit;
}
// getメソッドでidの取得
$id = (int) $_GET['id'];

// idを指定してdbからデータ取得
$dbh = db_open();
$sql = "SELECT id, title, isbn, price, publish, author FROM books WHERE id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(":id", $id, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC); //フィールド名がキーの配列を取得
if (!$result) {
    echo "指定したデータはありません";
    exit;
}

// データをフォームに配置
$title = str2html($result['title']);
$isbn = str2html($result['isbn']);
$price = str2html($result['price']);
$publish = str2html($result['publish']);
$author = str2html($result['author']);
$id = str2html($result['id']);

// edoで囲んだ範囲が文字列として扱われる
$html_form = <<<EDO
<form action='update.php' method='post'>
    <p>
    <label for='title'>タイトル:</label>
    <input type='text' name='title' value='$title'>
    </p>
    <p>
    <label for='isbn'>ISBN:</label>
    <input type='text' name='isbn' value='$isbn'>
    </p>
    <p>
    <label for='price'>価格:</label>
    <input type='text' name='price' value='$price'>
    </p>
    <p>
    <label for='publish'>出版日:</label>
    <input type='text' name='publish' value='$publish'>
    </p>
    <p>
    <label for='author'>著者:</label>
    <input type='text' name='author' value='$author'>
    </p>
    <p class='button'>
        <input type='hidden' name='id' value='$id'>
        <input type='submit' value='送信する'>
    </p>
</form>
EDO;
echo $html_form;
