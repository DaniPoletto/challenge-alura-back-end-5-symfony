<?php

namespace App\Controller;

use App\Factory\VideoFactory;
use App\Controller\BaseController;
use App\Repository\VideoRepository;
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
        VideoFactory $videoFactory
    ) {
        parent::__construct
        (
            $videoRepository, 
            $entityManager, 
            $videoFactory
        );
    }

    /**
     * @Route("/video/{id}", methods={"PUT"})
     */
    public function atualiza(int $id, Request $request) : Response
    {
        $corpoRequisicao = $request->getContent();
        $videoEnviado = $this->factory->criarEntidade($corpoRequisicao);

        if ($this->repository
            ->VerificaSeJaExisteDespesaComOutroID(
                $id,
                $videoEnviado->getDescricao(),
                $videoEnviado->getTitulo()
            ) >0
        ) 
            return new JsonResponse(["Erro" => "Já existe outro video igual."]);

        $videoExistente = $this->repository->find($id);

        if (is_null($videoExistente)) {
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        $videoExistente->setDescricao($videoEnviado->getDescricao()); 
        $videoExistente->setTitulo($videoEnviado->getTitulo()); 

        $this->entityManager->flush();

        return new JsonResponse($videoExistente);
    }

    /**
     * @param Video $entityExistente
     * @param Video $entityEnviado
     */
    public function atualizarEntidadeExistente($entityExistente, $entityEnviado)
    {
        $entityExistente->setDescricao($entityEnviado->getDescricao()); 
    }
}
