<?php

namespace App\Controller;

use App\Factory\VideoFactory;
use App\Helper\ResponseFactory;
use App\Controller\BaseController;
use App\Repository\VideoRepository;
use App\Helper\ExtratorDadosRequest;
use App\Repository\CategoriaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VideoController extends BaseController
{
    /**
     * @var VideoFactory
     */
    private $videoFactory;

    /**
     * @var CategoriaRepository
     */
    private $categoriaRepository;

    public function __construct(
        VideoRepository $videoRepository,
        EntityManagerInterface $entityManager,
        VideoFactory $videoFactory,
        ExtratorDadosRequest $extratorDadosRequest,
        CategoriaRepository $categoriaRepository
    ) {
        $this->categoriaRepository = $categoriaRepository;
        parent::__construct
        (
            $videoRepository, 
            $entityManager, 
            $videoFactory,
            $extratorDadosRequest,
        );
    }

    /**
     * @param Video $entityExistente
     * @param Video $entityEnviado
     */
    public function atualizarEntidadeExistente($entityExistente, $entityEnviado)
    {
        $entityExistente->setTitulo($entityEnviado->getTitulo()); 
        $entityExistente->setDescricao($entityEnviado->getDescricao()); 
        $entityExistente->setUrl($entityEnviado->getUrl()); 

        if ($entityEnviado->getIdCategoria() != NULL) {
            $entityExistente->setIdCategoria($entityEnviado->getIdCategoria()); 
        }
    }

    public function verificaSeJaTemUm($entity)
    {
        return $this->repository->count(
            [
                'titulo' => $entity->getTitulo(),
                'descricao' => $entity->getDescricao(),
                'url' => $entity->getUrl(),
            ]
        );
    }

    public function verificaSeJaTemUmComOutroId($id, $entityEnviado)
    {
        return $this->repository
            ->VerificaSeJaExisteVideoComOutroID(
            $id,
            $entityEnviado->getDescricao(),
            $entityEnviado->getTitulo()
        );
    }

    public function setValoresDefault($entity) 
    {
        if ($entity->getIdCategoria() == NULL) {
            $categoria = $this->categoriaRepository->find(1);
            $entity->setIdCategoria($categoria);
        }

        return $entity;
    }

    public function buscaPorCategoria(int $id): JsonResponse
    {
        $videos = $this->repository->findBy([
            'id_categoria' => $id
        ]);

        $fabrica = new ResponseFactory(
            true,
            $videos,
            Response::HTTP_OK
        );
        return $fabrica->getResponse();
    }
}
