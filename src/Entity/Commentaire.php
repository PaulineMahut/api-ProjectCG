<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CommentaireRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CommentaireRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['read_commentaire']], denormalizationContext: ['groups' => ['write_commentaire']])]
class Commentaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[Groups(['read_commentaire', 'write_commentaire'])]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text')]
    #[Groups(['read_commentaire', 'write_commentaire'])]
    private $libelle;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }
}
