<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ClientRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['read_client']], denormalizationContext: ['groups' => ['write_client']])]
class Client extends User
{
    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read_client', 'write_client'])]
    private $nom;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read_client', 'write_client'])]
    private $prenom;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read_client', 'write_client'])]
    private $adress;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read_client', 'write_client'])]
    private $ville;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read_client', 'write_client'])]
    private $pays;

    #[ORM\Column(type: 'integer')]
    #[Groups(['read_client', 'write_client'])]
    private $telephone;

    #[ORM\ManyToOne(targetEntity: Panier::class, inversedBy: 'client')]
    #[Groups(['read_client', 'write_client'])]
    private $panier;

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): self
    {
        $this->telephone = $telephone;

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
