<?php

try {

    $host = 'db';
    $dbname = 'crud_php';
    $user = 'pma';
    $pass = '123456';
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
    $conn = new PDO($dsn, $user, $pass);
  
    $sql = 'SELECT * FROM productos';
    foreach ($conn->query($sql) as $row) {
       var_dump($row);
    }

} catch (\Throwable $t) {
    echo 'Error: ' . $t->getMessage();
    echo '<br />';
}
