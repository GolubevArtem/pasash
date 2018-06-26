<?php
include 'db.php';

$sth = $dbh->prepare("SELECT * FROM `tree`");
$sth->execute();
$category = $sth->fetchAll(PDO::FETCH_ASSOC);

function convert($array, $i = 'id_tree', $p = 'id_family')
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

        return (isset($ids[0])) ? convert_node($ids, 0, 'children') : false;
    }
}

function convert_node($index, $root, $cn)
{
    $_ret = array();
    foreach ($index[$root] as $k => $v) {
        $_ret[$k] = $v;
        if (isset($index[$k])) {
            $_ret[$k][$cn] = convert_node($index, $k, $cn);
        }
    }

    return $_ret;
}

$category = convert($category);

function out_tree_checkbox($array, $first = true)
{
    if ($first) {
        $out = '<ul id="navigation" class="treeview">';
    } else {
        $out = '<ul>';
    }
    foreach ($array as $row) {
        $out .= '<li class="expandable">';
        $out .= '<div class="hitarea expandable-hitarea"></div>';
        $out .= '<a href = ?id_tree=[' . $row['id_tree'] . ']>' . $row['name_tree'] . '</a>';
        if (isset($row['children'])) {
            $out .= out_tree_checkbox($row['children'], false);
        }
        $out .= '</li>';
    }
    $out .= '</ul>';

    return $out;
}


   echo out_tree_checkbox($category);

?>
