<?php

namespace App\Factory;

use App\Entity\Video;
use App\Factory\EntidadeFactory;
use App\Repository\CategoriaRepository;

class VideoFactory implements EntidadeFactory
{

    /**
     * @var CategoriaRepository
     */
    private $categoriaRepository;

    public function __construct(CategoriaRepository $categoriaRepository)
    {
        $this->categoriaRepository = $categoriaRepository;
    }

    public function criarEntidade(string $json) : Video
    {
        $dadoEmJson = json_decode($json);

        $video = new Video();
        $video->setTitulo($dadoEmJson->titulo);
        $video->setDescricao($dadoEmJson->descricao);
        $video->setUrl($dadoEmJson->url);

        if (isset($dadoEmJson->IdCategoria)) {
            $categoria = $this->categoriaRepository->find($dadoEmJson->IdCategoria);
            $video->setIdCategoria($categoria);
        }

        return $video;
    }
}