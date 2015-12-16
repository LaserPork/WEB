<?php

include("connect.php");

    $myusername = $_POST['nick'];
    $mypassword = $_POST['password'];

    $sql = "SELECT * FROM users WHERE nick LIKE '$myusername' AND heslo LIKE '$mypassword'";
    $statement = $dbh->prepare($sql);
    $statement->execute();
    $error = $statement->errorInfo();
    $rows = $statement->fetch(PDO::FETCH_ASSOC);

?>