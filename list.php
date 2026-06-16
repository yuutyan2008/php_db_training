<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h1>書籍データベース</h1>
    </header>
    <?php
    require_once 'functions.php';
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

        // プレースホルダの作成
        $sql = "SELECT * FROM books";
        $statement = $dbh->query($sql);
    ?>
        <table>
            <tr>
                <th>更新</th>
                <th>書籍名</th>
                <th>ISBN</th>
                <th>価格</th>
                <th>出版日</th>
                <th>著者名></th>
            </tr>
            <?php while ($row = $statement->fetch()): ?>
                <tr>
                    <td><a href="edit.php?id=<?php echo (int) $row['id']; ?>">更新</a>
                    <td><?php echo str2html($row['title']) ?></td>
                    <td><?php echo str2html($row['isbn']) ?></td>
                    <td><?php echo str2html($row['price']) ?></td>
                    <td><?php echo str2html($row['publish']) ?></td>
                    <td><?php echo str2html($row['author']) ?></td>
                </tr>
            <?php endwhile ?>
        </table>


    <?php
    } catch (PDOException $e) {
        echo "エラーが発生しました: " . $e->getMessage();
        exit;
    }
    ?>
</body>

</html>
