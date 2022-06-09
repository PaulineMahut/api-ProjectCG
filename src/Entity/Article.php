<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['read_article']], denormalizationContext: ['groups' => ['write_article']])]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read_article', 'write_article'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read_article', 'write_article'])]
    private $nom;

    #[ORM\Column(type: 'float')]
    #[Groups(['read_article', 'write_article'])]
    private $prix;

    #[ORM\ManyToOne(targetEntity: Panier::class, inversedBy: 'article')]
    #[Groups(['read_article', 'write_article'])]
    private $panier;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getPanier(): ?Panier
    {
        return $this->panier;
    }

    public function setPanier(?Panier $panier): self
    {
        $this->panier = $panier;

        return $this;
    }
}
