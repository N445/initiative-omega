<?php

namespace App\Entity\Rsi\Ship;

use App\Entity\Exploit\Exploit;
use App\Repository\Rsi\Ship\ManufacturerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ManufacturerRepository::class)]
#[UniqueEntity('id_rsi')]
#[Vich\Uploadable]
#[ORM\Table(name: 'manufacturer')]
class Manufacturer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int                $id             = null;

    #[ORM\Column]
    private ?int                $rsiId          = null;

    #[ORM\Column(length: 255)]
    private ?string             $name           = null;

    #[ORM\Column(length: 255)]
    private ?string             $rsi_image_name = null;

    #[ORM\OneToMany(mappedBy: 'manufacturer', targetEntity: Ship::class, cascade: ["persist", "remove"])]
    private Collection          $ships;

    #[Vich\UploadableField(mapping: 'rsi_manufacturer', fileNameProperty: 'imageName', size: 'imageSize')]
    private ?File               $imageFile      = null;

    #[ORM\Column(type: 'string')]
    private ?string             $imageName      = null;

    #[ORM\Column(type: 'integer')]
    private ?int                $imageSize      = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $updatedAt      = null;

    #[ORM\ManyToMany(targetEntity: Exploit::class, mappedBy: 'manufacturers')]
    private Collection $exploits;

    public function __construct()
    {
        $this->ships = new ArrayCollection();
        $this->exploits = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getRsiId(): ?int
    {
        return $this->rsiId;
    }

    /**
     * @param int|null $rsiId
     * @return Manufacturer
     */
    public function setRsiId(?int $rsiId): Manufacturer
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

    public function getRsiImageName(): ?string
    {
        return $this->rsi_image_name;
    }

    public function setRsiImageName(string $rsi_image_name): self
    {
        $this->rsi_image_name = $rsi_image_name;

        return $this;
    }

    /**
     * @return Collection<int, Ship>
     */
    public function getShips(): Collection
    {
        return $this->ships;
    }

    public function addShip(Ship $ship): self
    {
        if (!$this->ships->contains($ship)) {
            $this->ships->add($ship);
            $ship->setManufacturer($this);
        }

        return $this;
    }

    public function removeShip(Ship $ship): self
    {
        if ($this->ships->removeElement($ship)) {
            // set the owning side to null (unless already changed)
            if ($ship->getManufacturer() === $this) {
                $ship->setManufacturer(null);
            }
        }

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
     * @return Manufacturer
     */
    public function setUpdatedAt(?\DateTimeInterface $updatedAt): Manufacturer
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
            $exploit->addManufacturer($this);
        }

        return $this;
    }

    public function removeExploit(Exploit $exploit): self
    {
        if ($this->exploits->removeElement($exploit)) {
            $exploit->removeManufacturer($this);
        }

        return $this;
    }

}
