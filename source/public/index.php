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

function fetchALL()
{
    $sql = "SELECT * FROM todo";
    $query = dbConnect()->query($sql);

    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function create($text)
{
    $now = date('Y/m/d H:i:s');
    $sql = 'insert into todo (text, created_at, updated_at) values (?, ?, ?)';
    $stmt = dbConnect()->prepare($sql);

    $stmt->execute([$text, $now, $now]);
}

function update($id, $text)
{
    $sql = 'UPDATE todo SET text = ?, updated_at = ? WHERE todo.id = ?';

    $stmt = dbConnect()->prepare($sql);

    $stmt->execute([$text, date('Y/m/d H:i:s'), $id]);
}

function delete($id)
{
    $sql = 'delete from todo WHERE todo.id = ?';
    $stmt = dbConnect()->prepare($sql);

    $stmt->execute([$id]);
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(!empty($_POST['submit'])){
        create($_POST['submit']);
    }else if(isset($_POST['update'])){
        update($_POST['id'], $_POST['text']);
    }else if(isset($_POST['delete'])){
        delete($_POST['id']);
    }

    // index.phpにリダイレクト
    header('Location: '.$_SERVER['SCRIPT_NAME']);
    exit;
}

$DATA = fetchALL();
?>

<section>
            <form method="post">
                <input type="text" name="submit" required>
                <button type="submit">作成する</button>
            </form>

            <table>
                <?php
                    if ($DATA) {
                ?>
                    <tr>
                        <th bgcolor="#808080" rowspan="2"><font color="#FFFFFF">TODO</font></th>
                        <th bgcolor="#808080" rowspan="2"><font color="#FFFFFF">作成日</font></th>
                        <th bgcolor="#808080" colspan="2" id="action"><font color="#FFFFFF">操作</font></th>
                    </tr>
                    <tr>
                        <th bgcolor="#808080" headers="action"><font color="#FFFFFF">更新</font></th>
                        <th bgcolor="#808080" headers="action"><font color="#FFFFFF">削除</font></th>
                    </tr>
                <?php
                    }
                ?>

                <?php foreach((array)$DATA as $row): ?>
                    <form method= "post">
                        <tr>
                            <input type= "hidden" name= "id" value= "<?php echo $row["id"]; ?>">
                            <td>
                                <input type="text" name="text" value=<?php echo $row["text"]; ?> required>
                            </td>
                            <td>
                                <?php echo $row["created_at"]; ?>
                            </td>
                            <td>
                                <button type="submit" name="update">更新する</button>
                            </td>
                            <td>
                                <button type="submit" name="delete">削除する</button>
                            </td>
                        </tr>
                    </form>
                <?php endforeach; ?>
            </table>
        </section>

</body>

</html>