<?php

namespace App\Factory;

use App\Entity\Video;

class VideoFactory implements EntidadeFactory
{

    public function __construct()
    {
        
    }

    public function criarEntidade(string $json) : Video
    {
        $dadoEmJson = json_decode($json);

        $video = new Video();
        $video->setTitulo($dadoEmJson->titulo);
        $video->setDescricao($dadoEmJson->descricao);
        $video->setUrl($dadoEmJson->url);

        return $video;
    }
}