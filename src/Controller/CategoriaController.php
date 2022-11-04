<?php

namespace App\Controller;

use App\Helper\ResponseFactory;
use App\Factory\CategoriaFactory;
use App\Controller\BaseController;
use App\Helper\ExtratorDadosRequest;
use App\Repository\CategoriaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoriaController extends BaseController
{
    /**
     * @var CategoriaFactory
     */
    private $categoriaFactory;

    public function __construct(
        CategoriaRepository $categoriaRepository,
        EntityManagerInterface $entityManager,
        CategoriaFactory $categoriaFactory,
        ExtratorDadosRequest $extratorDadosRequest
    ) {
        parent::__construct
        (
            $categoriaRepository, 
            $entityManager, 
            $categoriaFactory,
            $extratorDadosRequest,
        );
    }

    /**
     * @param Categoria $entityExistente
     * @param Categoria $entityEnviado
     */
    public function atualizarEntidadeExistente($entityExistente, $entityEnviado)
    {
        $entityExistente->setTitulo($entityEnviado->getTitulo()); 
        $entityExistente->setCor($entityEnviado->getCor()); 
    }

    public function verificaSeJaTemUm($entity)
    {
        return $this->repository->count(
            [
                'titulo' => $entity->getTitulo()
            ]
        );
    }

    public function verificaSeJaTemUmComOutroId($id, $entityEnviado)
    {
        return $this->repository
            ->VerificaSeJaExisteCategoriaComOutroID(
            $id,
            $entityEnviado->getTitulo()
        );
    }

    public function setValoresDefault($entity) 
    {
        return $entity;
    }
}
