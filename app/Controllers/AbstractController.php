<?php
namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;

abstract class AbstractController
{
    protected $request;

    public function __construct()
    {
        $this->request = new Request();
    }

    protected function jsonResponse($data, $statusCode = 200)
    {
        if ($statusCode >= 200 && $statusCode < 300) 
        {
            Response::success($data, $statusCode);
        }
        $message = is_array($data) && isset($data['error']) ? $data['error'] : (is_string($data) ? $data : 'Erro desconhecido');
        Response::error($message, $statusCode);
    }
}