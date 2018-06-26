<?php
include ('db.php');

$select = $dbh->prepare('SELECT `qnt` FROM `parts_tree` WHERE `id` = '.$_POST["id"].' LIMIT 1');
$select->execute();
$selres = $select->fetchAll(PDO::FETCH_ASSOC);
foreach ($selres as $row) {
    $sum = $row["qnt"] + $_POST["qnt"];
    if ($sum < 0 && $_POST["qnt"] <0){
        echo ("<script>window.alert( 'Не может быть меньше нуля !!!')</script>");
    }
    else {
        $result = $dbh->prepare("UPDATE `parts_tree` set  `qnt` = '" . $sum . "'  WHERE  `id` = " . $_POST["id"]);
        $result->execute();
       // print_r($result);
     //   print_r($result->errorInfo());
    }
}
?>