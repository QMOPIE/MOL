<?php
// PDO SQL連線程式
$dsn="mysql:host=localhost;dbname=qmo;charset=utf8";
$user="root";
$password="";
$link=new PDO($dsn,$user,$password);
date_default_timezone_set("Asia/Taipei");


?>