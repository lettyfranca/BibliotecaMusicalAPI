<?php
namespace App\Models;

use Throwable;

class Musica
{
    private $file = __DIR__ . '/../../data/musicas.json';

    private function readData()
    {
        try {
            if (!file_exists($this->file)) {
                throw new \Exception("Arquivo de dados não encontrado.");
            }

            $json = file_get_contents($this->file);
            $data = json_decode($json, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception("Erro ao decodificar JSON: " . json_last_error_msg());
            }

            return $data;
        } catch (Throwable $e) {
            throw new \Exception("Erro ao ler dados: " . $e->getMessage());
        }
    }

    private function writeData($data)
    {
        try {
            $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

            if ($json === false) {
                throw new \Exception("Erro ao codificar JSON: " . json_last_error_msg());
            }

            file_put_contents($this->file, $json);
        } catch (Throwable $e) {
            throw new \Exception("Erro ao escrever dados: " . $e->getMessage());
        }
    }

    public function findAll()
    {
        return $this->readData();
    }

    public function findById($id)
    {
        $musicas = $this->readData();
        foreach ($musicas as $musica)
        {
            if ($musica['id'] == $id)
            {
                return $musica;
            }
        }
        return null;
    }

    public function create($newMusica)
    {
        $musicas = $this->readData();
        $newId = end($musicas)['id'] + 1;
        $newMusica = array_merge(['id' => $newId], $newMusica);
        $musicas[] = $newMusica;
        $this->writeData($musicas);
        return $newMusica;
    }

    public function update($id, $updatedData)
    {
        $musicas = $this->readData();
        foreach ($musicas as $index => $musica) 
        {
            if ($musica['id'] == $id)
            {
                $musicas[$index] = array_merge($musica, $updatedData);
                $this->writeData($musicas);
                return $musicas[$index];
            }
        }
        return null;
    }

    public function delete($id)
    {
        $musicas = $this->readData();
        foreach ($musicas as $index => $musica) {
            if ($musica['id'] == $id) {
                array_splice($musicas, $index, 1);
                $this->writeData($musicas);
                return true;
            }
        }
        return false;
    }
}