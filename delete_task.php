<?php
session_start();
if(!isset($_SESSION["admin"]) || $_SESSION["admin"] != 1){
    header("Location: login.php");
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["task_number_delete"])) {
    $individualNumber = $_POST["task_number_delete"];

    // Искомый шаблон для поиска файлов с задачами
    $taskFilePattern = "tasks/" . "*_" . $individualNumber . ".*";

    // Ищем все файлы, удовлетворяющие шаблону
    $matchingFiles = glob($taskFilePattern);

    if (count($matchingFiles) > 0) {
        echo "<p>Задача с индивидуальным номером " . $individualNumber . " найдена.</p>";

        // Удаляем все найденные файлы с задачами, если пользователь подтвердил
        foreach ($matchingFiles as $file) {
            if (unlink($file)) {
                echo "<p>Файл " . basename($file) . " успешно удален. Возвращение в админ панель через 5 секунд.</p>";
                echo '<a href="admin.php">Или нажмите сюда</a>';
                echo '<meta http-equiv="refresh" content="5;url=admin.php">';
            } else {
                echo "<p>Ошибка при удалении файла " . basename($file) . ". Возвращение в админ панель через 5 секунд.</p>";
                echo '<a href="admin.php">Или нажмите сюда</a>';
                echo '<meta http-equiv="refresh" content="5;url=admin.php">';
            }
        }

    } else {
        echo "<p>Задача с индивидуальным номером " . $individualNumber . " не найдена.</p>";
    }
}
?>