<?php
include 'db.php';

$sth = $dbh->prepare("SELECT * FROM `parts_tree` WHERE parent = :parent ORDER BY `title` ASC, LENGTH (`orig`) ASC, `orig` ASC");
$sth->bindParam(':parent', $_GET['id_tree']);
$sth->execute();
$category = $sth->fetchAll(PDO::FETCH_ASSOC);

function convert_p($array, $i = 'id', $p = 'parent_id')
{
    if (!is_array($array)) {
        return array();
    } else {
        $ids = array();
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                if ((isset($v[$i]) || ($i === false)) && isset($v[$p])) {
                    $key = ($i === false) ? $k : $v[$i];
                    $parent = $v[$p];
                    $ids[$parent][$key] = $v;
                }
            }
        }

        return (isset($ids[0])) ? convert_node_p($ids, 0, 'children') : false;
    }
}

function convert_node_p($index, $root, $cn)
{
    $_ret = array();
    foreach ($index[$root] as $k => $v) {
        $_ret[$k] = $v;
        if (isset($index[$k])) {
            $_ret[$k][$cn] = convert_node_p($index, $k, $cn);
        }
    }

    return $_ret;
}

$category = convert_p($category);

function out_parts($array)
{
    $out ='';
    if(is_array($array) || is_object($array)){
        foreach ($array as $row) {
            $out .= '<tr class="table-row '.$row["id"].'">';
            $out .= '<td class="to_del"><button class="btn" onclick="delete_pos(' . $row["id"] . ')"></button></td>';

            if ($row["parent_id"] == 0) {

                // title cell
                $out .= '<td contenteditable="true" onKeydown="Javascript: if (event.keyCode==13) entersave(this,\'title\','.$row["id"].');" onClick="showEdit(this);">';
                $out .= $row["title"];
                $out .= '</td>';

                // orig cell
                $out .= '<td class="volvo" contenteditable="true" onKeydown="Javascript: if (event.keyCode==13) entersave(this,\'orig\','.$row["id"].');" onClick="showEdit(this);" >';
                $out .= $row["orig"];
                $out .= '</td>';

                // similar cell
                $out .= '<td>
                    <div id="demo-modal-target">
	                <div onclick="loadDynamicContentModal('.$_GET["id_tree"].', \'jquery\','. $row["id"] .')"
		                class="btn-modal-target" id="btn-jquery">Добавить аналог</div>
                    </div>
                <div id="demo-modal"></div>';

                $out .= '</td>';

            }else{
                // title cell
                $out .='<td class="empty" val='.$row["parent_id"].'></td>';

                // orig cell
                $out .='<td class="orig_arrow"><input type="image" src="img/sim_arrow.png" alt="аналоги" width="32" height="32" align="right"></td>';

                // similar cell
                $out .= '<td contenteditable="true" onKeydown="Javascript: if (event.keyCode==13) entersave(this,\'similar\','.$row["id"].');" onClick="showEdit(this);">';
                $out .= $row["similar"];
                $out .= '</td>';
            }
// comment
            $out .= '<td contenteditable="true" onKeydown="Javascript: if (event.keyCode==13) entersave(this,\'coment\','.$row["id"].');" onClick="showEdit(this);">';
            $out .= $row["coment"];
            $out .= '</td>';



// qnt change by enter

            $out .= '<td class="qnt"><button class="minus" onclick="qntchange(' . $row["id"] . ', -1)"><input type="image" src="img/minus.png" alt="minus" width="12" height="12"></button>&nbsp ';// строка для версии с кнопками
            $out .= '<span class="qnt_on_fly" contenteditable="true" onKeydown="Javascript: if (event.keyCode==13) entersave(this,\'qnt\','.$row["id"].');" onClick="showEdit(this);">';///
            $out .= $row["qnt"];
            $out .= '</span>';/////
            $out .= '&nbsp<button class="plus" onclick="qntchange(' . $row["id"] . ', 1)"><input type="image" src="img/plus.png" alt="plus" width="12" height="12"></button>'; // строка для версии с кнопками
            $out .= '</td>';

// qnt2 change by enter
            $out .= '<td class="qnt"><button class="minus" onclick="qntchange2(' . $row["id"] . ', -1)"><input type="image" src="img/minus.png" alt="minus" width="12" height="12"></button>&nbsp ';
            $out .= '<span class="qnt_on_fly" contenteditable="true" onKeydown="Javascript: if (event.keyCode==13) entersave(this,\'qnt2\','.$row["id"].');" onClick="showEdit(this);">';///
            $out .= $row["qnt2"];
            $out .= '</span>';/////
            $out .= '&nbsp<button class="plus" onclick="qntchange2(' . $row["id"] . ', 1)"><input type="image" src="img/plus.png" alt="plus" width="12" height="12"></button>'; // строка для версии с кнопками
            $out .= '</td>';

            // price

            $out .= '<td class="price" contenteditable="true" onKeydown="Javascript: if (event.keyCode==13) entersave(this,\'price\','.$row["id"].');" onClick="showEdit(this);">';
            $out .= $row["price"];
            $out .= '</td>';


            // warehouse

            //$out .='<td class="warehouse"><form><select name = "new_warehouse" onchange="changewarehouse(this.value,\'warehouse\','.$row["id"].')">';
            //if ($row["warehouse"] == "w1") {
             //   $out .= '<option  value = "w1" selected>Склад 1</option><option  value = "w2">Склад 2</option></select></form>';
            //}else {
             //   $out .= '<option  value = "w1">Склад 1</option><option  value = "w2" selected>Склад 2</option></select></form>';
            //}
            //$out .= '</td>';

            $out .= '</tr>';

            if (isset($row['children'])) {
                $out .= out_parts($row['children'], false);
            }

        }
}


    return $out;

}


if($_SERVER['REQUEST_METHOD']=='POST')
{

    add_part($dbh, $_POST['parent_id'], $_GET['id_tree']);

}

function add_part($dbh, $parent_id, $id_tree)
{
    if (isset($_POST['new_title'])) {
        $title = $_POST['new_title'];
        if ($title == '') {
            unset($title);
        }
    }
    if (isset($_POST['new_orig'])) {
        $orig = $_POST['new_orig'];
        if ($orig == '') {
            unset($orig);
        }
    }

    if (isset($_POST['new_similar'])) {
        $similar = $_POST['new_similar'];
        if ($similar == '') {
            unset($similar);
        }
    }

    if (isset($_POST['new_coment'])) {
        $coment = $_POST['new_coment'];
        if ($coment == '') {
            unset($coment);
        }
    }
    if (isset($_POST['new_qnt'])) {
        $qnt = intval($_POST['new_qnt']);
        if ($qnt == '') {
            $qnt = 0;
        }
    }

    if (isset($_POST['new_qnt2'])) {
        $qnt2 = intval($_POST['new_qnt2']);
        if ($qnt2 == '') {
            $qnt2 = 0;
        }
    }

    if ( $parent_id == NULL) {
        $parent_id = 0;
    }

    if (isset($_POST['new_price'])) {
        $price = $_POST['new_price'];
        if ($price == '') {
            unset($price);
        }
    }

//    if (isset($_POST['new_warehouse'])) {
//        $warehouse = $_POST['new_warehouse'];
//        if ($warehouse == '') {
//            unset($warehouse);
//        }
//    }

    $title = stripslashes($title);
    $title = htmlspecialchars($title);
    $title = trim($title);

    $orig = stripslashes($orig);
    $orig = htmlspecialchars($orig);
    $orig = trim($orig);

    $similar = stripslashes($similar);
    $similar = htmlspecialchars($similar);
    $similar = trim($similar);

    $coment = stripslashes($coment);
    $coment = htmlspecialchars($coment);
    $coment = trim($coment);

    $price = stripslashes($price);
    $price = htmlspecialchars($price);
    $price = trim($price);

    if (empty($id_tree)){
        echo ("<script>window.alert( 'Выберите категорию !!!')</script>");
    }
    else{
        $add = $dbh->prepare("INSERT INTO `parts_tree`(`parent`,`parent_id`, `title`, `orig`, `similar`,  `coment` ,  `qnt`,  `qnt2`,  `price`) VALUES (:parent, :parent_id,  :title, :orig, :similar, :coment, :qnt, :qnt2, :price)");
        $add->bindParam(':parent', $id_tree);
        $add->bindParam(':parent_id',  $parent_id);
        $add->bindParam(':title', $title);
        $add->bindParam(':orig', $orig);
        $add->bindParam(':similar', $similar);
        $add->bindParam(':coment', $coment);
        $add->bindParam(':qnt', $qnt);
        $add->bindParam(':qnt2', $qnt2);
        $add->bindParam(':price', $price);
        $add->execute();

        unset($_POST);
       // print_r ($add);
       // print_r ($add->errorInfo());

        echo "<meta http-equiv='refresh' content='1'>";
    }
}

echo out_parts($category);

?>