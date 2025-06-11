<?php
namespace App\Core;

class Request 
{
    private $method;
    private $body;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];

        $input = file_get_contents('php://input');
        $this->body = json_decode($input, true);

        if (empty($this->body))
        {
            $this->body = $_REQUEST;
        }
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getBody()
    {
        return $this->body;
    }
}