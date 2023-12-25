<?php
// Логин и хэш пароля, замените на свои реальные значения
$storedUsername = 'Help!';
$storedHashedPassword = '$2y$10$AIw1axCR9M1lyKCaK8sy8e5tBg937w3DIwwqiOjpffA3X8AxgB/2K';

// Проверяем, были ли переданы данные из формы
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем введенные данные из формы
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Проверяем введенные данные с сохраненными
    if ($username === $storedUsername && password_verify($password, $storedHashedPassword)) {
        // Пароль верный, выполните действия, которые нужно сделать после успешной авторизации
        echo "Здравствуйте, Аркадий ";
        session_start();
        $_SESSION['admin'] = 1;
        echo 'Вы успешно вошли, телепортация в админ панель через 5 секунд ';
        echo '<a href="admin.php">Или нажмите сюда</a>';
        echo '<meta http-equiv="refresh" content="5;url=admin.php">';
    } else {
        // Пароль неверный
        echo "Неверное имя пользователя или пароль.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Адаптивная страница входа</title>
    <!-- Подключаем Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="mb-4">Вход</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label for="username">Имя пользователя</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Войти</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
