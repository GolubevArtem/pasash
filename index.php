<?php
session_start();?>
<!DOCTYPE HTML>
<html>
<head>
    <title>PaSash</title>
    <meta charset="utf-8">
    <script src="js/jquery-2.1.1.min.js"></script>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/vertica_rhythm.css">
    <script src="js/jquery.cookie.js"></script>
</head>
<body>

<?php
//header('Content-Type: text/html; charset=utf-8');
// Проверяем, пусты ли переменные логина и id пользователя
if (empty($_SESSION['login']) or empty($_SESSION['id']))
{
    ?>
    <!--Если пусты, то выводим форму входа.-->
    <div id="main_form">
        <div class="login">
            <form action="check.php" method="post">
                <label>логин:</label><br/>
                <input name="users_login" type="text" size="15" maxlength="15"><br/>
                <label>пароль:</label><br/>
                <input name="users_password" type="password" size="15" maxlength="15"><br/><br/>
                <input type="submit" value="войти"><br/><br/>
            </form>
        </div>
    </div>
    <?php
}else{
    exit("<meta http-equiv='refresh' content='0; url= main.php'>");
}
?>
</body>
</html>