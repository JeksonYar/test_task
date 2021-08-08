<?php
// Подключаем коннект к БД
require_once 'db.php';

// Проверка есть ли хеш
if ($_GET['hash']) {
    $hash = $_GET['hash'];
    // Получаем id и подтверждено ли Email
    if ($result = mysqli_query($db, "SELECT `id`, `email_confirmed` FROM `user` WHERE `hash`='" . $hash . "'")) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo $row['id'] . " " . $row['email_confirmed'];
            if ($row['email_confirmed'] == 1) {
                mysqli_query($db, "UPDATE `user` SET `email_confirmed`=0 WHERE `id`=" . $row['id']);
                echo "Email подтверждён";
            } else {
                echo "Что то пошло не так";
            }
        }
    } else {
        echo "Что то пошло не так";
    }
} else {
    echo "Что то пошло не так";
}
