<!DOCTYPE html>
<html>
<head>
    <title>Простая страница для шифрования текста</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="mb-4">Шифрование текста</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label for="plaintext">Введите текст для шифрования</label>
                    <input type="text" class="form-control" id="plaintext" name="plaintext" required>
                </div>
                <button type="submit" class="btn btn-primary">Зашифровать</button>
            </form>
            <?php
            // Обработка данных после отправки формы
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Получаем введенный текст для шифрования
                $plaintext = $_POST["plaintext"];

                // Создаем хэш пароля на основе введенного текста
                $hashedText = password_hash($plaintext, PASSWORD_DEFAULT);

                // Выводим зашифрованный текст
                echo '<div class="mt-3"><strong>Зашифрованный текст:</strong><br>' . $hashedText . '</div>';
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>
s