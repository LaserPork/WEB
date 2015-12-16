<?php
$array = array(
    "uzivatel" => $_SESSION['id'],
    "nazev" => $_POST["textinputprispevek"],
    "obsah" => $_POST["textareaprispevek"]
);
$user->DBInsert('prispevky',$array);
$connection = $user->GetPDOConnection();
$id = $connection->lastInsertId();
$array = array(
    "prispevek" => $id
);
$user->DBInsert('recenze',$array);
$user->DBInsert('recenze',$array);
$user->DBInsert('recenze',$array);
$stranka = 'mojeprispevky';