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

    #[ORM\Column(type: 'string', length: 3, nullable: true)]
    #[Groups(['read_article', 'write_article'])]
    private $longueur;

    #[ORM\Column(type: 'string', length: 3, nullable: true)]
    #[Groups(['read_article', 'write_article'])]
    private $largeur;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['read_article', 'write_article'])]
    private $description;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['read_article', 'write_article'])]
    private $image;

    #[ORM\ManyToOne(targetEntity: Categorie::class, inversedBy: 'articles')]
    #[Groups(['read_article', 'write_article'])]
    private $categorie;

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

    public function getLongueur(): ?string
    {
        return $this->longueur;
    }

    public function setLongueur(?string $longueur): self
    {
        $this->longueur = $longueur;

        return $this;
    }

    public function getLargeur(): ?string
    {
        return $this->largeur;
    }

    public function setLargeur(?string $largeur): self
    {
        $this->largeur = $largeur;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }
}
