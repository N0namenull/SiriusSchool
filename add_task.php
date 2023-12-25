<?php
session_start();
if (!isset($_SESSION["admin"]) || $_SESSION["admin"] != 1) {
    header("Location: login.php");
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["task_file"])) {
    $taskFile = $_FILES["task_file"]["name"];
    $taskName = pathinfo($taskFile, PATHINFO_FILENAME);
    $rash = pathinfo($taskFile, PATHINFO_EXTENSION);

    if (!empty($_POST["task_individual"])) {
        $targetPath = 'tasks/' . $_POST["task_individual"] . '.' . $rash;
        if (move_uploaded_file($_FILES["task_file"]["tmp_name"], $targetPath)) {
            echo 'Вы успешно добавили задачу ' . $_POST["task_individual"] . ", Возвращение в админ панель через 5 секунд ";
        } else {
            echo 'При добавлении задачи произошла ошибка, попробуйте еще раз. Возвращение в админ панель через 5  ';
        }
        echo '<a href="admin.php">Или нажмите сюда</a>';
        echo '<meta http-equiv="refresh" content="5;url=admin.php">';
        exit;
    }
    else {
        $targetPath = 'tasks/' . $taskName . '.' . $rash;
        if (move_uploaded_file($_FILES["task_file"]["tmp_name"], $targetPath)) {
            echo 'Вы успешно добавили задачу ' . $taskName . ", Возвращение в админ панель через 5 секунд ";
        } else {
            echo 'При добавлении задачи произошла ошибка, попробуйте еще раз. Возвращение в админ панель через 5  ';
        }
        echo '<a href="admin.php">Или нажмите сюда</a>';
        echo '<meta http-equiv="refresh" content="5;url=admin.php">';
        exit;
    }

}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["answ_file"])) {
    $answFile = $_FILES["answ_file"]["name"];
    $answName = pathinfo($answFile, PATHINFO_FILENAME);
    $rash_answ = pathinfo($answFile, PATHINFO_EXTENSION);

    if (!empty($_POST["answ_individual"])){
        $targetPath_answ = 'tasks/' . $_POST["answ_individual"] . '_resh' . '.' . $rash_answ;
        if (move_uploaded_file($_FILES["answ_file"]["tmp_name"], $targetPath_answ)) {
            echo 'Вы успешно добавили ответ к задаче ' . $_POST["answ_individual"] . ", Возвращение в админ панель через 5 секунд ";
        } else {
            echo 'При добавлении задачи произошла ошибка, попробуйте еще раз. Возвращение в админ панель через 5  ';
        }
        echo '<a href="admin.php">Или нажмите сюда</a>';
        echo '<meta http-equiv="refresh" content="5;url=admin.php">';
        exit;
    }

    else{
        $targetPath_answ = 'tasks/' . $answName . '.' . $rash_answ;
        if (move_uploaded_file($_FILES["answ_file"]["tmp_name"], $targetPath_answ)) {
            echo 'Вы успешно добавили ответ ' . $answName . ", Возвращение в админ панель через 5 секунд ";
        } else {
            echo 'При добавлении задачи произошла ошибка, попробуйте еще раз. Возвращение в админ панель через 5  ';
        }
        echo '<a href="admin.php">Или нажмите сюда</a>';
        echo '<meta http-equiv="refresh" content="5;url=admin.php">';
        exit;
    }
}
?>