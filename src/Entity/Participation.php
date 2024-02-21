<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use App\Repository\ParticipationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParticipationRepository::class)]
class Participation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $id_user = null;

    #[ORM\Column(length: 255)]
    private ?string $name_user = null;

    #[ORM\Column(length: 255)]
    private ?string $id_event = null;

    #[ORM\OneToMany(targetEntity: Evenement::class, mappedBy: 'participation')]
    private Collection $evenements;

    public function __construct()
    {
        $this->evenements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?string
    {
        return $this->id_user;
    }

    public function setIdUser(string $id_user): static
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getNameUser(): ?string
    {
        return $this->name_user;
    }

    public function setNameUser(string $name_user): static
    {
        $this->name_user = $name_user;

        return $this;
    }

    public function getIdEvent(): ?string
    {
        return $this->id_event;
    }

    public function setIdEvent(string $id_event): static
    {
        $this->id_event = $id_event;

        return $this;
    }

    /**
     * @return Collection<int, Evenement>
     */
    public function getEvenements(): Collection
    {
        return $this->evenements;
    }

    public function addEvenement(Evenement $evenement): static
    {
        if (!$this->evenements->contains($evenement)) {
            $this->evenements->add($evenement);
            $evenement->setParticipation($this);
        }

        return $this;
    }

    public function removeEvenement(Evenement $evenement): static
    {
        if ($this->evenements->removeElement($evenement)) {
            // set the owning side to null (unless already changed)
            if ($evenement->getParticipation() === $this) {
                $evenement->setParticipation(null);
            }
        }

        return $this;
    }

  
}
