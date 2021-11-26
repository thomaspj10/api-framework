<?php

class Response {

    private $message;
    private $responseCode;
    private $success;
    public $data;

    function __construct($message = "OK", $responseCode = 200) {
        $this->message = $message;
        $this->responseCode = $responseCode;
        $this->success = $responseCode < 400;
        $this->data = new stdClass();
    }

    function display() {
        http_response_code($this->responseCode);

        $response = new stdClass();
        $response->message = $this->message;
        $response->success = $this->success;
        $response->data = $this->data;

        header("Content-Type: application/json");
        echo json_encode($response, JSON_PRETTY_PRINT);
        exit();
    }

}

?>