<?php
session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>PaSash</title>
    <meta charset="utf-8">
    <script src="js/jquery-2.1.1.min.js"></script>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/vertica_rhythm.css">
</head>
<body>
<div>
    <div class="exit">
        <a href='exit.php'>выйти</a>
    </div>
    <div class="add_user">



        <?php
        //header('Content-Type: text/html; charset=utf-8');
        //setlocale(LC_ALL,'ru_RU.65001','rus_RUS.65001','Russian_Russia.65001','russian');
        //session_start();//  вся процедура работает на сессиях. Именно в ней хранятся данные  пользователя, пока он находится на сайте. Очень важно запустить их в  самом начале странички!!!
        if (isset($_POST['users_login'])) { $login = $_POST['users_login']; if ($login == '') { unset($login);} } //заносим введенный пользователем логин в переменную $login, если он пустой, то уничтожаем переменную
        if (isset($_POST['users_password'])) { $password=$_POST['users_password']; if ($password =='') { unset($password);} }
        if (empty($_SESSION['login']) or empty($_SESSION['id']) or ($_SESSION['id'] !=1)) {
            exit("<meta http-equiv='refresh' content='0; url= index.php'>");
        }
        //заносим введенный пользователем пароль в переменную $password, если он пустой, то уничтожаем переменную
        if (empty($login) or empty($password)) //если пользователь не ввел логин или пароль, то выдаем ошибку и останавливаем скрипт
        {
            exit ("<body><div align='center'><br/><br/><br/>
	<h3>Введите Логин и пароль." . "<a href='add.php'> <b>Добавить</b> </a></h3></div></body>");
        }
        //если логин и пароль введены,то обрабатываем их, чтобы теги и скрипты не работали, мало ли что люди могут ввести
        $login = stripslashes($login);
        $login = htmlspecialchars($login);
        $password = stripslashes($password);
        $password = htmlspecialchars($password);
        //удаляем лишние пробелы
        $login = trim($login);
        $password = trim($password);
        $password = md5(md5($password));

        include 'db.php';

// проверить есть ли такой пользователь, если есть update pass если нет, то insert

        $user_check = $dbh->prepare("SELECT * FROM users WHERE users_login = '".$login."' LIMIT 1");
        $user_check->execute();
        $users_arr = $user_check->fetch(PDO::FETCH_ASSOC);

        if (false ) {

            $upd = $dbh->prepare("UPDATE users SET users_password = :pass WHERE users_login = :name ");
            $upd->bindParam(':name', $login);
            $upd->bindParam(':pass', $password);
            $upd->execute();

        }




else {
    $add = $dbh->prepare("INSERT INTO users (users_login, users_password) VALUES (:name , :pass)");
    $add->bindParam(':name', $login);
    $add->bindParam(':pass', $password);
    $add->execute();
}

        $result = $dbh->prepare("SELECT * FROM users WHERE users_login = '".$login."' LIMIT 1");
        $result->execute();
        $myrow = $result->fetch(PDO::FETCH_ASSOC);

        if ($myrow["users_password"] == $password)
        {

            exit ("<body><div align='center'><br/><br/><br/>
	<h3>Пользователь ".$login." добавлен." . "<a href='exit.php'> <b>Выйти</b> </a></h3></div></body>");
        }
        else {
            exit ("<body><div align='center'><br/><br/><br/>
	<h3>Пользователь не добавлен." . "<a href='add.php'> <b>Добавить</b> </a></h3></div></body>");

            }
        ?>

    </div>

</div>

</body>
</html>
