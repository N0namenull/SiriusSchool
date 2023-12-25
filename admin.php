<?php
session_start();
if(!isset($_SESSION["admin"]) || $_SESSION["admin"] != 1){
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель</title>
    <!-- Подключаем Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Админ-панель</h2>
    <form action="add_task.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="task_number">Номер задачи:</label>
            <input type="text" class="form-control" id="task_individual" name="task_individual" placeholder="Введите номер задачи полностью, либо оставьте поле пустым чтобы оставить прежнее название">
            <input type="file" class="form-control" id="task_file" accept="image/*,.pdf" name="task_file" required>
        </div>
        <button type="submit" class="btn btn-primary">Добавить задачу</button>
    </form>

    <h3 class="mt-5">Добавить ответ</h3>
    <form action="add_task.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="task_number">Номер ответа:</label>
            <input type="text" class="form-control" id="answ_individual" name="answ_individual" placeholder="Введите номер ответа полностью, либо оставьте поле пустым чтобы оставить прежнее название">
            <input type="file" class="form-control" id="answ_file" accept="image/*,.pdf" name="answ_file" required>
        </div>
        <button type="submit" class="btn btn-primary">Добавить задачу</button>
    </form>

    <h3 class="mt-5">Удаление задачи</h3>
    <form action="delete_task.php" method="post">
        <div class="form-group">
            <label for="task_number_delete">Номер задачи для удаления:</label>
            <input type="text" class="form-control" id="task_number_delete" name="task_number_delete" required>
        </div>
        <button type="submit" class="btn btn-danger">Удалить задачу</button>
    </form>


    <h4 class="mt-5">Добавить новость</h4>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="form-group">
            <label for="newsInput">Введите новость:</label>
            <textarea class="form-control" id="newsInput" name="news" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Добавить новость</button>
    </form>
    <?php
    // Проверка, что данные были отправлены через POST-запрос
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Получение введенной пользователем новости
        $news = $_POST['news'];

        // Форматирование новости с текущей датой
        $formattedNews = date('Y-m-d') . ' | ' . trim($news) . PHP_EOL;

        // Имя файла, в который будем записывать новости
        $newsFile = 'news.txt';

        // Открытие файла на запись с дополнением
        $file = fopen($newsFile, 'a');

        // Запись новости в файл
        fwrite($file, $formattedNews);

        // Закрытие файла
        fclose($file);

        echo '<p class="mt-3 text-success">Новость успешно добавлена!</p>';
    }
    ?>
</div>
<!-- Подключаем Bootstrap JS и jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
