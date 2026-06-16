<?php
require_once 'functions.php';
// validation
if (empty($_POST['title'])) {
    echo ('タイトルは必須です');
    exit;
}
if (!preg_match('/\A[[:^cntrl:]]{1,200}\z/u', $_POST['title'])) {
    echo ('タイトルは200文字以内で入力してください');
    exit;
}
if (!preg_match('/\A\d{0,13}\z/', $_POST['isbn'])) {
    echo ('ISBNは数字13桁までです');
    exit;
}
if (!preg_match('/\A\d{0,6}\z/u', $_POST['price'])) {
    echo ('価格は6桁までの整数で入力してください');
    exit;
}
if (empty($_POST['publish'])) {
    echo ('出版日は必須です');
    exit;
}
if (!preg_match('/\A\d{4}-\d{1,2}-\d{1,2}\z/u', $_POST['publish'])) {
    echo ('出版日はYYYY-MM-DD形式で入力してください');
    exit;
}
$data = explode('-', $_POST['publish']);
if (!checkdate((int)$data[1], (int)$data[2], (int)$data[0])) {
    echo ('出版日は正しい日付を入力してください');
    exit;
}
if (!preg_match('/\A[[:^cntrl:]]{0,80}\z/u', $_POST['author'])) {
    echo ('著者名は80文字以内で入力してください');
    exit;
}

try {
    // 下記部分をfunctions.phpのdb_open関数に置き換え
    $dbh = db_open();
    // $user = "localhost";
    // $password = "satomitest";

    // $opt = [
    //     PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    //     PDO::ATTR_EMULATE_PREPARES => false,
    //     PDO::MYSQL_ATTR_MULTI_STATEMENTS => false,
    // ];
    // $dbh = new PDO('mysql:host=localhost;dbname=sample_db', $user, $password, $opt);

    $sql = "INSERT INTO books (id, title, isbn, price, publish, author) VALUES (:id, :title, :isbn, :price, :publish, :author)";
    //SQL実行時 (プレースホルダのまま実行)
    $stmt = $dbh->prepare($sql);
    // プレースホルダーの値の置き換え
    $stmt->bindParam(":title", $_POST["title"], PDO::PARAM_STR);
    $stmt->bindParam(":isbn", $_POST["isbn"], PDO::PARAM_STR);
    $stmt->bindParam(":price", $_POST["price"], PDO::PARAM_INT);
    $stmt->bindParam(":publish", $_POST["publish"], PDO::PARAM_STR);
    $stmt->bindParam(":author", $_POST["author"], PDO::PARAM_STR);
    // SQLの実行
    $stmt->execute();
    echo "登録が完了しました！";

    echo "<br><a href='add.html'>リストへ戻る</a>";
} catch (PDOException $e) {
    echo "エラーが発生しました: " . $e->getMessage();
}
