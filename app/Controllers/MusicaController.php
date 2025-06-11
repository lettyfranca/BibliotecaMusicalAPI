<?php
namespace App\Controllers;

use App\Models\Musica;

class MusicaController extends AbstractController
{
    private $model;

    public function __construct()
    {
        $this->model = new Musica();
    }

    public function index()
    {
        $musicas = $this->model->findAll();
        $this->jsonResponse($musicas);
    }

    public function view($id)
    {
        $musica = $this->model->findById($id);
        if ($musica) {
            $this->jsonResponse($musica);
        } else {
            $this->jsonResponse(['Música não encontrada'], 404);
        }
    }

    public function add()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data || !isset($data['nome']) || !isset($data['artista']) || !isset($data['album'])) {
            return $this->jsonResponse(['Dados inválidos'], 400);
        }

        $novaMusica = $this->model->create($data);
        $this->jsonResponse($novaMusica, 201);
    }

    public function edit($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $musicaAtualizada = $this->model->update($id, $data);
        if ($musicaAtualizada) {
            $this->jsonResponse($musicaAtualizada);
        } else {
            $this->jsonResponse(['Música não encontrada'], 404);
        }
    }

    public function delete($id)
    {
        $sucesso = $this->model->delete($id);
        if ($sucesso) {
            $this->jsonResponse(['message' => 'Música deletada com sucesso.']);
        } else {
            $this->jsonResponse(['Música não encontrada'], 404);
        }
    }

}