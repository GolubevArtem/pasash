<?php
try {
    $dbh = new PDO('mysql:dbname=PASASH;host=localhost', 'root', 'Aa12345678+',array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
} catch (PDOException $e) {
    die($e->getMessage());
}
?>

