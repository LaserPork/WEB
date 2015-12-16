<?php
$hostname = 'localhost';
$username = 'root';
$password = '';

try {
    $dbh = new PDO("mysql:host=$hostname;dbname=local_db", $username, $password);
}
catch(PDOException $e)
{
    // zobrazit chybu
    echo $e->getMessage();
}
?>