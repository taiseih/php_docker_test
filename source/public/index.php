<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>ToDoアプリ</h1>
    <?php
    echo "Hello World";
    ?>
    <?php
    // 疎通確認
    function dbConnect()
    {
        $dsn = 'mysql:host=mysql;dbname=todo;charset=utf8';
        $user = 'todo';
        $password = 'todo';

        try {
            new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,]);

            var_dump("疎通確認OK!");
        } catch (PDOException $e) {
            header('Content-Type: text/plain; charset=UTF-8', true, 500);
            var_dump($e->getMessage());
            exit();
        }
    }

    dbConnect();
// end疎通確認

?>
</body>

</html>