<?php
require("database.php");
require("response.php");

$endpoints = json_decode(file_get_contents("endpoints.json"));
$requested_url = $_SERVER["REQUEST_URI"];

$database = new Database();

foreach ($endpoints as $endpoint) {
    // Check if the path and method are valid with the endpoint.
    if ($endpoint->path !== $requested_url) continue;
    if ($endpoint->method !== $_SERVER["REQUEST_METHOD"]) continue;

    // Ensure that the file specified exists on the disk.
    $file = "./endpoints/" . $endpoint->file;

    if (!file_exists($file)) {
        $response = new Response("Internal server error", 500);
        $response->display();
    }

    // If the endpoint requires oauth check the Authorization.
    if ($endpoint->oauth) {
        $token = $_SERVER["HTTP_AUTHORIZATION"];

        $statement = $database->prepare("select * from members where token=?");
        $statement->execute(array($token));
        $userdata = $statement->fetch();

        if ($userdata === false) {
            $response = new Response("Unauthorized", 401);
            $response->display();
        }
    }

    // Check if the required parameters are valid.
    foreach ($endpoint->parameters ?: [] as $parameter) {
        if (!isset($_POST[$parameter])) {
            $response = new Response("Missing required parameter '$parameter'", 400);
            $response->display();
        }
    }

    // Execute the specified endpoint.
    include($file);

    $response = new Response();
    $response->display();
}

$response = new Response("Not Found", 404);
$response->display();

?>