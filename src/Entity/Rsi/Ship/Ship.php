<?php

namespace App\Entity\Rsi\Ship;

use App\Entity\Exploit\Exploit;
use App\Entity\Rsi\Ship\Ship\Info;
use App\Entity\User\Fleet;
use App\Repository\Rsi\Ship\ShipRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ShipRepository::class)]
#[UniqueEntity('rsiId')]
#[Vich\Uploadable]
#[ORM\Table(name: 'ship')]
class Ship
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int                $id           = null;

    #[ORM\Column]
    private ?int                $rsiId        = null;

    #[ORM\Column(length: 255)]
    private ?string             $name         = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string             $type         = null;

    #[ORM\Column(length: 255)]
    private ?string             $bannerImage  = null;

    #[ORM\Column(length: 255)]
    private ?string             $link         = null;

    #[ORM\OneToMany(mappedBy: 'ship', targetEntity: Fleet::class)]
    private Collection          $fleets;

    #[ORM\ManyToOne(inversedBy: 'ships')]
    private ?Manufacturer       $manufacturer = null;

    #[Vich\UploadableField(mapping: 'rsi_ship', fileNameProperty: 'imageName', size: 'imageSize')]
    private ?File               $imageFile    = null;

    #[ORM\Column(type: 'string')]
    private ?string             $imageName    = null;

    #[ORM\Column(type: 'integer')]
    private ?int                $imageSize    = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $updatedAt    = null;

    #[ORM\ManyToMany(targetEntity: Exploit::class, mappedBy: 'ships')]
    private Collection          $exploits;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Info               $info         = null;

    public function __construct()
    {
        $this->fleets   = new ArrayCollection();
        $this->exploits = new ArrayCollection();
        $this->info     = new Info();
    }

    public function __toString(): string
    {
        return sprintf('%s - %s - %s', $this->getManufacturer()->getName(), $this->getName(), $this->getType());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRsiId(): ?int
    {
        return $this->rsiId;
    }

    public function setRsiId(int $rsiId): self
    {
        $this->rsiId = $rsiId;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getBannerImage(): ?string
    {
        return $this->bannerImage;
    }

    public function setBannerImage(string $bannerImage): self
    {
        $this->bannerImage = $bannerImage;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getNbTotalInFleets(?bool $buyInGame = null)
    {
        $nb = 0;
        foreach ($this->getFleets() as $fleet) {
            if (null !== $buyInGame) {
                if ($fleet->isIsBuyInGame() !== $buyInGame) {
                    continue;
                }
            }
            $nb += $fleet->getNumberShips();
        }
        return $nb;
    }

    /**
     * @return Collection<int, Fleet>
     */
    public function getFleets(): Collection
    {
        return $this->fleets;
    }

    public function addFleet(Fleet $fleet): self
    {
        if (!$this->fleets->contains($fleet)) {
            $this->fleets->add($fleet);
            $fleet->setShip($this);
        }

        return $this;
    }

    public function removeFleet(Fleet $fleet): self
    {
        if ($this->fleets->removeElement($fleet)) {
            // set the owning side to null (unless already changed)
            if ($fleet->getShip() === $this) {
                $fleet->setShip(null);
            }
        }

        return $this;
    }

    public function getManufacturer(): ?Manufacturer
    {
        return $this->manufacturer;
    }

    public function setManufacturer(?Manufacturer $manufacturer): self
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTimeInterface|null $updatedAt
     * @return Ship
     */
    public function setUpdatedAt(?\DateTimeInterface $updatedAt): Ship
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return Collection<int, Exploit>
     */
    public function getExploits(): Collection
    {
        return $this->exploits;
    }

    public function addExploit(Exploit $exploit): self
    {
        if (!$this->exploits->contains($exploit)) {
            $this->exploits->add($exploit);
            $exploit->addShip($this);
        }

        return $this;
    }

    public function removeExploit(Exploit $exploit): self
    {
        if ($this->exploits->removeElement($exploit)) {
            $exploit->removeShip($this);
        }

        return $this;
    }

    public function getInfo(): ?Info
    {
        return $this->info;
    }

    public function setInfo(?Info $info): self
    {
        $this->info = $info;

        return $this;
    }

}
