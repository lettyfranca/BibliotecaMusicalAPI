<?php
namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use Throwable;

abstract class AbstractController
{
    protected $request;

    public function __construct()
    {
        $this->request = new Request();
    }

    protected function jsonResponse($data, $statusCode = 200)
    {
        try {
            if ($statusCode >= 200 && $statusCode < 300) 
            {
                Response::success($data, $statusCode);
            }   
            else
            {
                $message = is_array($data) && isset($data['error']) ? $data['error'] : (is_string($data) ? $data : 'Erro desconhecido');
                Response::error($message, $statusCode);
            }
        } catch (Throwable $e) {
            Response::error('Erro interno: ' . $e->getMessage(), 500);
        }       
    }
}