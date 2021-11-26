<?php

$password = hash("sha256", $_POST["password"] . "TVStHVVvYodeYAiZCYWv");

$statement = $database->prepare("select token from members where email=? and password=?");
$statement->execute(array($_POST["email"], $password));
$data = $statement->fetch();

if ($data === false) {
    $response = new Response("Invalid email or password.", 401);
    $response->display();
}

$response = new Response();
$response->data->token = $data["token"];
$response->display();

?>