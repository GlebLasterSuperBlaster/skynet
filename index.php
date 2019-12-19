<?php
session_start();
    include "mainController.php";
    $run = new mainController();
    $run->runAction();


echo ("<form action=\"index.php\" method=\"post\">
 <p>Введите id пользователя для поиска тарифа: <input type=\"text\" name=\"userId\" /></p>
 <p><input type=\"submit\" /></p>
</form>");
