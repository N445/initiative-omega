<?php

namespace App\Entity\Event;

use App\Repository\Event\TypeRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: TypeRepository::class)]
#[ORM\Table(name: 'event_type')]
#[Vich\Uploadable]
class Type
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int       $id    = null;

    #[ORM\Column(length: 255)]
    private ?string    $name  = null;

    #[ORM\Column(length: 255)]
    private ?string    $title = null;

    #[ORM\Column(length: 255)]
    private ?string    $code  = null;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: Event::class)]
    private Collection $events;


    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private         $image;

    #[UploadableField(mapping: 'eventtype', fileNameProperty: 'image')]
    private         $imageFile;


    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string             $color      = null;

    public function __construct()
    {
        $this->events     = new ArrayCollection();
        $this->updated_at = new DateTimeImmutable('NOW');
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return Type
     */
    public function setName(?string $name): Type
    {
        $this->name = $name;
        $this->setCode((new AsciiSlugger())->slug($name)->lower());
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string|null $code
     * @return Type
     */
    public function setCode(?string $code): Type
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    /**
     * @param \DateTimeInterface|null $updated_at
     * @return Type
     */
    public function setUpdatedAt(?\DateTimeInterface $updated_at): Type
    {
        $this->updated_at = $updated_at;
        return $this;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
            $event->setType($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getType() === $this) {
                $event->setType(null);
            }
        }

        return $this;
    }


    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function setImageFile(File $image = null): self
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updated_at = new DateTimeImmutable('now');
        }

        return $this;
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getColor(): ?string
    {
        return $this->color !== '#000000' ? $this->color : null;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }
}
