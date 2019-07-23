<?php
include ('db.php');

$result = $dbh->prepare("DELETE FROM `parts_tree`  WHERE  `id` = " .$_POST["id"]);
$result->execute();
//print_r ($result);
//print_r ($result->errorInfo());
echo "<meta http-equiv='refresh' content='1'>";

?>