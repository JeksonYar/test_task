<?php
// Подключаем коннект к БД
require_once 'db.php';

// Проверяем нажата ли кнопка отправки формы
if (isset($_REQUEST['doGo'])) {

    // Все последующие проверки, проверяют форму и выводят ошибку
    // Проверка на совпадение паролей
    if ($_REQUEST['pass'] !== $_REQUEST['pass_rep']) {
        $error = 'Пароль не совпадает';
    }

    // Проверка есть ли вообще повторный пароль
    if (!$_REQUEST['pass_rep']) {
        $error = 'Введите повторный пароль';
    }

    // Проверка есть ли пароль
    if (!$_REQUEST['pass']) {
        $error = 'Введите пароль';
    }

    // Проверка есть ли email
    if (!$_REQUEST['email']) {
        $error = 'Введите email';
    }

    // Проверка есть ли логин
    if (!$_REQUEST['login']) {
        $error = 'Введите login';
    }

    // Если ошибок нет, то происходит регистрация 
    if (!$error) {
        $login = $_REQUEST['login'];
        $email = $_REQUEST['email'];
        // Пароль хешируется
        $pass = password_hash($_REQUEST['pass'], PASSWORD_DEFAULT);
        // хешируем хеш, который состоит из логина и времени
        $hash = md5($login . time());

        // Переменная $headers нужна для Email заголовка
        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "To: <$email>\r\n";
        $headers .= "From: <mail@example.com>\r\n";
        // Сообщение для Email
        $message = '
                <html>
                <head>
                <title>Подтвердите Email</title>
                </head>
                <body>
                <p>Что бы подтвердить Email, перейдите по <a href="http://example.com/confirmed.php?hash=' . $hash . '">ссылка</a></p>
                </body>
                </html>
                ';

        // Добавление пользователя в БД
        mysqli_query($db, "INSERT INTO `user` (`login`, `email`, `password`, `hash`, `email_confirmed`) VALUES ('" . $login . "','" . $email . "','" . $pass . "', '" . $hash . "', 1)");
        // проверяет отправилась ли почта
        if (mail($email, "Подтвердите Email на сайте", $message, $headers)) {
            // Если да, то выводит сообщение
            echo 'Подтвердите на почте';
        }
    } else {
        // Если ошибка есть, то выводить её 
        echo $error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Регистрация</title>
    <!-- Подключаем css -->
    <link rel="stylesheet" href="/front/styles/style.css">
    <link rel="stylesheet" href="/front/styles/registration.css">
</head>

<body>

    <header>
        <div class="menu2">
            <!-- Меню на побочных страницах -->
            <a href="/front/index.html" class="menu_button">HOME</a>
            <a href="/front/about.html" class="menu_button">ABOUT</a>
            <a href="/front/index.html"><img class="graficlogo" src="/front/img/logo-1.svg" alt="Logo"></a>
            <a href="/front/servise.html" class="menu_button">SERVICE</a>
            <a href="/front/contact.html" class="menu_button">CONTACT</a>
        </div>
    </header>
    <div class="registration">
        <!-- Форма регистрации -->
        <form action="<?= $_SERVER['SCRIPT_NAME'] ?>" method="post">
            <label>Логин</label>
            <input type="text" name="login" placeholder="Введите свой логин">
            <label>Почта</label>
            <input type="email" name="email" placeholder="Введите адрес своей почты">
            <label>Пароль</label>
            <input type="password" name="pass" placeholder="Введите пароль">
            <label>Подтверждение пароля</label>
            <input type="password" name="pass_rep" placeholder="Подтвердите пароль">
            <p><input type="submit" value="Зарегистрироваться" name="doGo"></p>
            <div class="button">
                <p>
                    У вас уже есть аккаунт? - <a href="authorization.php">Aвторизируйтесь</a>!
                </p>
            </div>
        </form>
    </div>
</body>


</html>