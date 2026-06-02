<?php

try {
    $user = "localhost";
    $password = "satomitest";
    $opt = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::MYSQL_ATTR_MULTI_STATEMENTS => false,
    ];
    $dbh = new PDO('mysql:host=localhost;dbname=sample_db', $user, $password, $opt);

    $sql = "SELECT title, author FROM books";
    $statement = $dbh->query($sql);

    while ($row = $statement->fetch()) {
        echo "書籍名:" . $row[0] . "<br>";
        echo "著者名:" . $row[1] . "<br><br>";
    }
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    // 本番用
    // echo "エラー！: <br>";
}
