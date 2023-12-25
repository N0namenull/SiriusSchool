<?php
// Чтение новостей из файла
$newsFile = 'news.txt';
$lines = file($newsFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$news = [];
foreach ($lines as $line) {
    list($date, $text) = explode('|', $line, 2);
    $news[] = ['date' => trim($date), 'text' => trim($text)];
}

// Отображение последних 5 новостей
$latestNews = array_slice($news, 0, 5);

// Вывод HTML для новостей
echo '<style>
    .little-text{
    font-size: 0.95rem;
    }
</style>';
echo '<div class="list-group">';
foreach ($latestNews as $item) {
    echo '<li class="list-group-item">';
    echo '<span class="badge badge-secondary text-dark">' . $item['date'] . '</span>';
    echo '<span class="text-dark little-text">' . $item['text'] . '</span>';
    echo '</a>';
}
echo '</div>';
?>
