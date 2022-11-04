<?php

namespace App\Controller;

use App\Helper\ResponseFactory;
use App\Factory\EntidadeFactory;
use App\Helper\ExtratorDadosRequest;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class BaseController extends AbstractController
{
    /**
     * @var ObjectRepository
     */
    protected $repository;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var EntidadeFactory
     */
    protected $factory;

     /**
     * @var ExtratorDadosRequest
     */
    protected $extratorDadosRequest;


    public function __construct(
        ObjectRepository $repository,
        EntityManagerInterface $entityManager,
        EntidadeFactory $factory,
        ExtratorDadosRequest $extratorDadosRequest
    ) {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
        $this->factory = $factory;
        $this->extratorDadosRequest = $extratorDadosRequest;
    }
    
    public function buscarTodos(Request $request) : Response
    {
        $informacoesDeOrdenacao = $this->extratorDadosRequest->buscaDadosOrdenacao($request);
        $informacoesDeFiltro = $this->extratorDadosRequest->buscaDadosFiltro($request);
        [$paginaAtual, $itensPorPagina] = $this->extratorDadosRequest->buscaDadosPaginacao($request);
        
        $EntityList = $this->repository->findBy(
            $informacoesDeFiltro, 
            $informacoesDeOrdenacao,
            $itensPorPagina,
            ($paginaAtual - 1) * $itensPorPagina
        );

        $fabricaResposta = new ResponseFactory(
            true,
            $EntityList,
            Response::HTTP_OK,
            $paginaAtual,
            $itensPorPagina
        );

        return $fabricaResposta->getResponse();
    }

    public function buscarUm(int $id) : Response
    {
        $entity = $this->repository->find($id);

        $codigoRetorno = is_null($entity) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK;

        $fabricaResposta = new ResponseFactory(
            true,
            $entity,
            $codigoRetorno
        );

        return $fabricaResposta->getResponse();

    }

    public function remove(int $id) : Response
    {
        $entity = $this->repository->find($id);
        $this->repository->remove($entity, true);
        
        return new Response('', Response::HTTP_NO_CONTENT);
    }

    public function novo(Request $request): Response
    {
        $corpoRequisicao = $request->getContent();
        $entity = $this->factory->criarEntidade($corpoRequisicao);

        $entity = $this->setValoresDefault($entity);

        if ($this->verificaSeJaTemUm($entity))
            return new JsonResponse(
                ["Erro" => "Já existe um registro com esses valores."]
            );

        $this->repository->add($entity, true);

        return new JsonResponse($entity);
    }

    public function atualiza(int $id, Request $request) : Response
    {
        $corpoRequisicao = $request->getContent();
        $entityEnviado = $this->factory->criarEntidade($corpoRequisicao);

        if ($this->verificaSeJaTemUmComOutroId($id, $entityEnviado) >0) 
            return new JsonResponse(["Erro" => "Já existe outro registro igual."]);

        $entityExistente = $this->repository->find($id);

        if (is_null($entityExistente)) {
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        $this->atualizarEntidadeExistente($entityExistente, $entityEnviado);

        $this->entityManager->flush();

        $fabrica = new ResponseFactory(
            true,
            $entityExistente,
            Response::HTTP_OK
        );
        return $fabrica->getResponse();
    }

    abstract public function atualizarEntidadeExistente(
        $entityExistente,
        $entityEnviado
    );

    abstract public function verificaSeJaTemUm($entity);

    abstract public function verificaSeJaTemUmComOutroId($id, $entity);

    abstract public function setValoresDefault($entity);
}