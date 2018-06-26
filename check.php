<?php
//header('Content-Type: text/html; charset=utf-8');
//setlocale(LC_ALL,'ru_RU.65001','rus_RUS.65001','Russian_Russia.65001','russian');
session_start();//  вся процедура работает на сессиях. Именно в ней хранятся данные  пользователя, пока он находится на сайте. Очень важно запустить их в  самом начале странички!!!

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
    <script src="js/jquery.cookie.js"></script>
</head>
<body>
<div id="main_form">
    <div class="login_err">

<?php
//header('Content-Type: text/html; charset=utf-8');
//setlocale(LC_ALL,'ru_RU.65001','rus_RUS.65001','Russian_Russia.65001','russian');
//session_start();//  вся процедура работает на сессиях. Именно в ней хранятся данные  пользователя, пока он находится на сайте. Очень важно запустить их в  самом начале странички!!!

if (isset($_POST['users_login'])) { $login = $_POST['users_login']; if ($login == '') { unset($login);} } //заносим введенный пользователем логин в переменную $login, если он пустой, то уничтожаем переменную
if (isset($_POST['users_password'])) { $password=$_POST['users_password']; if ($password =='') { unset($password);} }
//заносим введенный пользователем пароль в переменную $password, если он пустой, то уничтожаем переменную
if (empty($login) or empty($password)) //если пользователь не ввел логин или пароль, то выдаем ошибку и останавливаем скрипт
{
    
    exit ("<body><div align='center'><br/><br/><br/><h3>" . "<a href='index.php'> <b>Login</b> </a></h3></div></body>");
}
$login = stripslashes($login);
$login = htmlspecialchars($login);
$password = stripslashes($password);
$password = htmlspecialchars($password);
$login = trim($login);
$password = trim($password);
$password = md5(md5($password));

include 'db.php';

$result = $dbh->prepare("SELECT * FROM users WHERE users_login = '".$login."' LIMIT 1");
$result->execute();


$myrow = $result->fetch(PDO::FETCH_ASSOC);

if (empty($myrow["users_password"]))
{
    //если пользователя с введенным логином не существует
    exit ("<body><div align='center'><br/><br/><br/>
	<h3>Извините, введённый вами login или пароль неверный." . "<a href='index.php'> <b>Login</b> </a></h3></div></body>");
}
else {
    //если существует, то сверяем пароли
    if ($myrow["users_password"]==$password) {
        $_SESSION['login']=$myrow["users_login"];
        $_SESSION['id']=$myrow["users_id"];//эти данные очень часто используются, вот их и будет "носить с собой" вошедший пользователь
        exit("<meta http-equiv='refresh' content='0; url= main.php'>");

    }
    else {
        //если пароли не сошлись

        exit ("<body><div align='center'><br/><br/><br/>
	<h3>Извините, введённый вами login или пароль неверный." . "<a href='index.php'> <b>Login</b> </a></h3></div></body>");
    }
}
?>

</div>
<div class="exit">
    <a href='exit.php'>выйти</a>
</div>
</div>

</body>
</html>
