<?php

$password = hash("sha256", $_POST["password"] . "TVStHVVvYodeYAiZCYWv");
$token = bin2hex(random_bytes(32));;

$statement = $database->prepare("insert into members values (0, ?, ?, ?)");
$statement->execute(array($_POST["email"], $password, $token));

?>