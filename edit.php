<?php
require_once 'functions.php';
echo $_GET['id'];
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
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$result) {
    echo "指定したデータはありません";
    exit;
}
var_dump($result);
