<?php

namespace App\Factory;

use App\Entity\Categoria;
use App\Factory\EntidadeFactory;

class CategoriaFactory implements EntidadeFactory
{

    public function __construct()
    {
        
    }

    public function criarEntidade(string $json) : Categoria
    {
        $dadoEmJson = json_decode($json);

        $categoria = new Categoria();
        $categoria->setTitulo($dadoEmJson->titulo);
        $categoria->setCor($dadoEmJson->cor);

        return $categoria;
    }
}