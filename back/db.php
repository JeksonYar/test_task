<?php
// Подключение к бд
$server = 'localhost';
$user = 'root';
$password = '';
$db = 'users';

$db = mysqli_connect($server, $user, $password, $db);

// Проверка на подключение
if (!$db) {
    echo "Не удается подключиться к серверу базы данных!";
    exit;
}
