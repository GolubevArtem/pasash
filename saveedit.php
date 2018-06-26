<?php
include ('db.php');

$result = $dbh->prepare("UPDATE `parts_tree` set  `" . $_POST["column"] . "` = '" .$_POST["editval"]. "'  WHERE  `id` = " .$_POST["id"]);

$result->execute();
//print_r ($result);
//print_r ($result->errorInfo());

?>