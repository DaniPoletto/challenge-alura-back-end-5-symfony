<?php

namespace App\Controller;

use App\Factory\VideoFactory;
use App\Controller\BaseController;
use App\Repository\VideoRepository;
use App\Helper\ExtratorDadosRequest;
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

    public function __construct(
        VideoRepository $videoRepository,
        EntityManagerInterface $entityManager,
        VideoFactory $videoFactory,
        ExtratorDadosRequest $extratorDadosRequest
    ) {
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
    }
}
