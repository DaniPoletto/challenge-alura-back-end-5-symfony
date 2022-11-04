<?php

namespace App\Entity;

use App\Repository\VideoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VideoRepository::class)
 */
class Video implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titulo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descricao;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\ManyToOne(targetEntity=Categoria::class, inversedBy="videos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_categoria;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getDescricao(): ?string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): self
    {
        $this->descricao = $descricao;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'titulo' => $this->getTitulo(),
            'descricao' => $this->getDescricao(),
            'url' => $this->getUrl(),
            'Idcategoria' => $this->getIdCategoria(),
            'categoria' => $this->getIdCategoria()->getTitulo(),
        ];
    }

    public function getIdCategoria(): ?Categoria
    {
        return $this->id_categoria;
    }

    public function setIdCategoria(?Categoria $id_categoria): self
    {
        $this->id_categoria = $id_categoria;

        return $this;
    }

}
