<?php

$db["db_host"] = "localhost";
$db["db_user"] = "root";
$db["db_pass"] = "";
$db["db_name"] = "dialang";

foreach($db as $key => $value){
    define(strtoupper($key), $value);
}

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);




/*
1. まず$db配列に4ペアを入れる
2. CONSTANTに入れるためのforeach
3. mysqli_connect()で接続
*/

?>