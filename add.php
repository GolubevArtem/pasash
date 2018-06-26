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

<?php
// Проверяем, пусты ли переменные логина и id пользователя
if (empty($_SESSION['login']) or empty($_SESSION['id']) or ($_SESSION['id'] !=1)) {
    exit("<meta http-equiv='refresh' content='0; url= index.php'>");
}
else
{

    ?>
    <!--Если пусты, то выводим форму входа.-->
    <div id="add_form">
        <div class="new_user">
            <form action="add_u.php" method="post">
                <label>логин:</label><br/>
                <input name="users_login" type="text" size="15" maxlength="15"><br/>
                <label>пароль:</label><br/>
                <input name="users_password" type="password" size="15" maxlength="15"><br/><br/>
                <input type="submit" value="добавить"><br/><br/>
            </form>
        </div>
    </div>
    <?php
}
?>
</body>
</html>