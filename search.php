<?php
//session_start();
//header('Content-Type: text/html; charset=utf-8');
include 'db.php';


/**
* поиск автокомплит
**/
if(!empty($_POST["referal"])) {
	$search = $_POST["referal"];

	$search = stripslashes($search);
	$search = htmlspecialchars($search);
	$search = trim($search);
	$post_search = "";
	$arr1 = str_split($search);
	foreach($arr1 as $elem){
		$post_search = $post_search. $elem ."%";
	}

	$ser = $dbh->prepare("
select * from `parts_tree`
where `orig` like '%{$post_search}'
or `similar` like '%{$post_search}'
or `title` like '%{$post_search}'
or `coment` like '%{$post_search}'
limit 10 ");
	$ser->execute();

//	print_r ($ser);
//   print_r ($ser->errorInfo());

	$s_result = $ser->fetchAll(PDO::FETCH_ASSOC);
	$result_search = array();

	foreach ($s_result as $row) {

		echo "<tr class='s_row'><td>" . $row["title"] . "</td><td>&nbsp" . $row["orig"] . "&nbsp</td><td>&nbsp" . $row["similar"] . "&nbsp</td><td>&nbsp" . $row["coment"] . "&nbsp</td></tr>
		<tr class='hid'><td class='id'>" . $row["id"] . "</td><td class='parent'>" . $row["parent"] . "</td></tr>";

	}

}
?>
