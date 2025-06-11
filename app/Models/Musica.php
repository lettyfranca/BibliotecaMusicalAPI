<?php
namespace App\Models;

class Musica
{
    private $file = __DIR__ . '/../../data/musicas.json';

    private function readData()
    {
        $json = file_get_contents($this->file);
        return json_decode($json, true);
    }

    private function writeData($data)
    {
        file_put_contents($this->file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
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