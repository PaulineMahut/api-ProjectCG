<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PanierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PanierRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['read_panier']], denormalizationContext: ['groups' => ['write_panier']])]
class Panier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read_panier', 'write_panier'])]
    private $id;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['read_panier', 'write_panier'])]
    private $date;

    #[ORM\OneToMany(mappedBy: 'panier', targetEntity: Article::class)]
    #[Groups(['read_panier', 'write_panier'])]
    private $article;

    #[ORM\OneToMany(mappedBy: 'panier', targetEntity: Client::class)]
    #[Groups(['read_panier', 'write_panier'])]
    private $client;

    public function __construct()
    {
        $this->article = new ArrayCollection();
        $this->client = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticle(): Collection
    {
        return $this->article;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->article->contains($article)) {
            $this->article[] = $article;
            $article->setPanier($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->article->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getPanier() === $this) {
                $article->setPanier(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Client>
     */
    public function getClient(): Collection
    {
        return $this->client;
    }

    public function addClient(Client $client): self
    {
        if (!$this->client->contains($client)) {
            $this->client[] = $client;
            $client->setPanier($this);
        }

        return $this;
    }

    public function removeClient(Client $client): self
    {
        if ($this->client->removeElement($client)) {
            // set the owning side to null (unless already changed)
            if ($client->getPanier() === $this) {
                $client->setPanier(null);
            }
        }

        return $this;
    }
}
