<?php
namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    /**
     * @Assert\NotBlank(message=" titre doit etre non vide")
     * @Assert\Length(
     *      min = 5,
     *      minMessage=" Entrer un titre au mini de 5 caracteres")
     *
     *     
     */

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max: 255)]
    private $titre;




    /**
 * @Assert\NotBlank(message="description  doit etre non vide")
 * @Assert\Length(
 *      min = 7,
 *      max = 100,
 *      minMessage = "doit etre >=7 ",
 *      maxMessage = "doit etre <=100" )
 */

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'date')]
    #[Assert\NotBlank]
    #[Assert\Type("\DateTimeInterface")]
    private $date;
    
    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private $lieu;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $image;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $latitude;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $longitude;

   
    private $participations;

    #[ORM\ManyToOne(inversedBy: 'evenements')]
    private ?Participation $participation = null;

    public function __construct()
    {
        $this->participations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate($date): self
    {
        if ($date instanceof \DateTimeInterface) {
            $this->date = $date;
        } else {
            try {
                $this->date = new \DateTime($date, new \DateTimeZone('UTC'));
            } catch (\Exception $e) {
                // Handle the exception or set a default value for $date if necessary
            }
        }
    
        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

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

    /**
     * @return Collection|Participation[]
     */
    public function getParticipations(): Collection
    {
        return $this->participations;
    }

    public function addParticipation(Participation $participation): self
    {
        if (!$this->participations->contains($participation)) {
            $this->participations[] = $participation;
            $participation->setEvenement($this);
        }

        return $this;
    }

    public function removeParticipation(Participation $participation): self
    {
        if ($this->participations->removeElement($participation)) {
            // set the owning side to null (unless already changed)
            if ($participation->getEvenement() === $this) {
                $participation->setEvenement(null);
            }
        }

        return $this;
    }

    public function getParticipation(): ?participation
    {
        return $this->participation;
    }

    public function setParticipation(?participation $participation): static
    {
        $this->participation = $participation;

        return $this;
    }
}

