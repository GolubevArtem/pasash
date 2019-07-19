<?php

	$dynamic_content_array = array("jquery" => "<div class='modal-text'>
	  <form  method=\"post\" >
        <div>
          <p>Данные аналога</p>
          <input name=\"parent_id\" type=\"hidden\" value=\" ".$_GET['parent_id']." \">
         <p><input name=\"new_similar\" type=\"text\" size=\"45\" maxlength=\"255\" placeholder=\"номер и фирма\" required></p>
         <p><input name=\"new_coment\" type=\"text\" size=\"45\" maxlength=\"255\" placeholder=\"примечание\"></p>
         <p><input name=\"new_qnt\" type=\"number\" size=\"25\" maxlength=\"255\" placeholder=\"количество\"></p>
         <p><input name=\"new_price\" type=\"number\" step=\".01\" size=\"25\" placeholder=\"цена\"></p>
         <p><select name=\"new_warehouse\"><option value = \"w1\">Склад 1</option><option value = \"w2\">Склад 2</option></select></p>
          <p><input type=\"submit\" class=\"close\" data-inline=\"true\"  value=\"Добавить\"></p>
        </div>
      </form></div>");
	
	if(!empty($_GET["modal"])) {print $dynamic_content_array[$_GET["modal"]];}
?>