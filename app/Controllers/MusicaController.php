<?php
namespace App\Controllers;

use App\Models\Musica;
use Throwable;

class MusicaController extends AbstractController
{
    private $model;

    public function __construct()
    {
        $this->model = new Musica();
    }

    public function index()
    {
        try {
            $musicas = $this->model->findAll();
            $this->jsonResponse($musicas);
        } catch (Throwable $e) {
            $this->jsonResponse($e->getMessage(), 500);
        }
    }

    public function view($id)
    {
        try {
            $musica = $this->model->findById($id);
            if ($musica) {
                $this->jsonResponse($musica);
            } else {
                $this->jsonResponse(['error' => 'Música não encontrada'], 404);
            }
        } catch (Throwable $e) {
            $this->jsonResponse($e->getMessage(), 500);
        }
    }

    public function add()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            if (!$data || !isset($data['nome']) || !isset($data['artista']) || !isset($data['album'])) {
                return $this->jsonResponse(['error' => 'Dados inválidos'], 400);
            }

            $novaMusica = $this->model->create($data);
            $this->jsonResponse($novaMusica, 201);
        } catch (Throwable $e) {
            $this->jsonResponse($e->getMessage(), 500);
        }
    }

    public function edit($id)
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $musicaAtualizada = $this->model->update($id, $data);
            if ($musicaAtualizada) {
                $this->jsonResponse($musicaAtualizada);
            } else {
                $this->jsonResponse(['error' => 'Música não encontrada'], 404);
            }
        } catch (Throwable $e) {
            $this->jsonResponse($e->getMessage(), 500);
        }
    }

    public function delete($id)
    {
        try {
            $sucesso = $this->model->delete($id);
            if ($sucesso) {
                $this->jsonResponse(['message' => 'Música deletada com sucesso.']);
            } else {
                $this->jsonResponse(['error' => 'Música não encontrada'], 404);
            }
        } catch (Throwable $e) {
            $this->jsonResponse($e->getMessage(), 500);
        }
    }

}