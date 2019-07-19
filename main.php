<?php
session_start();
//header('Content-Type: text/html; charset=utf-8');
if (empty($_SESSION['login']) or empty($_SESSION['id']))
{
    exit("<meta http-equiv='refresh' content='0; url= index.php'>");
    }
else
{
?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <title>PaSash</title>
    <meta charset="utf-8">
    <script src="js/jquery-2.1.1.min.js"></script>
    <script src="js/jquery.treeview.js"></script>
<!--    <script src="js/jquery.treeview.async.js"></script>-->
<!--    <script src="js/jquery.treeview.edit.js"></script>-->
    <link rel="stylesheet" href="css/jquery.treeview.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/vertica_rhythm.css">
    <script src="js/jquery-ui.js"></script>
    <link rel="stylesheet" href="css/jquery-ui.css">

    <script src="js/search.js"></script>
    <script src="js/search2.js"></script>
    <script src="js/jquery.cookie.js"></script>


    <link rel="SHORTCUT ICON" href="img/volvo_l.png" type="image/x-icon">
</head>
<body>
<header>
    <div id="header">
        <span class="logo">PaSash </span>
        <span class="search">
        <input type="text" name="referal" placeholder="поиск..." value="" class="who"  autocomplete="off">
            <table class="search_result"><th></th><th></th><th></th><th></th><th></th></table>

        </span>
        <span class="exit"><a href='exit.php'>выйти</a></span>
    </div>
</header>
<div id="centre">
<span class="left_tree">
        <?php include 'tree.php'; ?>
</span>
<span class="list">
    <table><tr>
            <th class="del_head">X</th>
            <th class="title">описание</th>
            <th class="orig">оригинальный номер</th>
            <th class="similar">аналоги</th>
            <th class="coment">Примечание</th>
            <th class="qnt">кол-во</th>
            <th class="price">цена за ед</th>
            <th class="warehouse">склад</th>
        </tr>
        <tr>


            <?php include 'parts_tree.php'; ?>


    <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>

        <?php
        $x = strval($_GET['id_tree']);
        if( strlen($x) > 3) {


          print  '<tr><td colspan = "8" > Введите название и номер оригинальной запчасти VOLVO </td ></tr >
        <tr><form method = "post" ><td ></td ><td ><input name = "new_title" type = "text" size = "50" maxlength = "200" placeholder="Название детали" required ></td >
        <td ><span class="search2"><input name = "new_orig" type = "text" size = "15" maxlength = "100" placeholder="номер"  class="who2"  autocomplete="off" required >
        <table class="search_result2"><th></th><th></th><th></th><th></th><th></th></table></span></td >
        <td ></td >
        <td ><input name = "new_coment" type = "text" size = "25" maxlength = "255" placeholder="примечание" ></td >
        <td ><input name = "new_qnt" type = "number" size = "3" min = "1" max = "999" placeholder="кол" ></td >
        <td ><input name = "new_price" type = "number" step=".01" maxlength = "7" style="width: 60px;" placeholder="цена" ></td >

        <td><select name = "new_warehouse">
                <option value = "w1">Склад 1</option>
                <option value= "w2">Склад 2</option>
            </select>&nbsp<input type = "submit" value = "+" ></td></tr ></form >';


        }
        else{
            print '<tr><td colspan = "8" > Выберите категорию слева для внесения или просмотра информации </td ></tr >';
        }

        ?>

    </td></table>
</span>
</div>
<footer>
    <div class="foot">
        ЖИЗНЬ ПРЕКРАСНА, КОГДА МЫ ВМЕСТЕ
    </div>
</footer>

<script>


    function entersave(editableObj,column,id)
    {
        saveToDatabase(editableObj,column,id);
    }

    function changewarehouse(editableObj,column,id)
    {
        console.log(editableObj);

        $.ajax({
            url: "saveedit.php",
            type: "POST",
            data:'column='+column+'&editval='+editableObj+'&id='+id,
            success: function(data){
                $(editableObj).css("background","#7fffd4");
                setTimeout("window.location.reload(true);", 30);
            }
        });

    }

// вход в редактирование
    function showEdit(editableObj) {
        $(editableObj).css("background","#eae051");

    }
// сохранить после редактирования
    function saveToDatabase(editableObj,column,id) {

        $(editableObj).css("background","#008000 url(css/images/loaderIcon.gif) no-repeat right");

        $.ajax({
            url: "saveedit.php",
            type: "POST",
            data:'column='+column+'&editval='+editableObj.innerText+'&id='+id,
            success: function(data){
                $(editableObj).css("background","#7fffd4");
                setTimeout("window.location.reload(true);", 30);
            }
        });
    }
// изменить количество
    function qntchange(id,change) {
        $.ajax({
            url: "qntchange.php",
            type: "POST",
            data:'&id='+id+'&qnt='+change,
            success: function(data){
                setTimeout("window.location.reload(true);", 10);
            }
        });
    }
// удалить запчасть
    function delete_pos(id) {
        if (window.confirm("ДЕЙСТВИТЕЛЬНО УДАЛИТЬ?")) {
            $.ajax({
                url: "delpart.php",
                type: "POST",
                data: '&id=' + id,
                success: function (data) {
                    setTimeout("window.location.reload(true);", 10);
                }
            });
        }
    }

//  модальное окно
    function loadDynamicContentModal(id_tree, modal, parent_id){
        var options = {
            modal: true,
            height:450,
            width:550
        };
        $('#demo-modal').load('get-dynamic-content.php?modal='+modal+'&parent_id='+parent_id+'&id_tree='+id_tree).dialog(options).dialog('open');
    }


//  дерево категорий
    $("#navigation").treeview({
        persist: "location",
        collapsed: true,
        unique: true
    });

//  отключить удаление оригинала с дочерними элементами

    $(document).ready(function () {
        var arr = $(".empty");
        jQuery.each(arr, function() {
            var aim = this.outerHTML.split('val="')[1].split('"')[0];
            $('.'+ aim +'').find('.to_del').find('.btn').css( "display", "none" );

        })

    })
</script>
    <script>

    $(document).ready(function () {
        var arr2 = $(".table-row");
        jQuery.each(arr2, function() {
            var tr_orig = $(this).find('.volvo').text().length;
            if (tr_orig != 0){
                $(this).css("background", "#c9e8ff");
            }
        })
    })

</script>


</body>
</html>
<?php
}
?>