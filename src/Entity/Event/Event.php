<?php

namespace App\Entity\Event;

use App\Entity\User;
use App\Interface\EventInterface;
use App\Repository\Event\EventRepository;
use App\Service\Event\EventAvailableForHelper;
use App\Service\Event\EventDateProvider;
use App\Service\Event\EventTypes;
use DateInterval;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\RRule as AssertRRule;

#[ORM\Entity(repositoryClass: EventRepository::class)]
#[ORM\Table(name: 'event')]
#[Vich\Uploadable]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int                $id                    = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string             $title                 = null;

    #[ORM\Column]
    private ?DateTime           $start_at              = null;

    #[ORM\Column]
    private ?DateTime           $end_at                = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    private ?DateInterval       $duration              = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[AssertRRule\RRule]
    #[Assert\Valid]
    private ?RRule              $rrule                 = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    private ?string             $content               = null;

    #[ORM\Column]
    #[Assert\NotNull]
    private ?bool               $has_rrule             = null;

    #[ORM\OneToMany(mappedBy: 'event', targetEntity: Date::class, cascade: ['persist', 'remove', 'refresh'], orphanRemoval: true)]
    private Collection          $dates;

    #[ORM\Column]
    private ?DateTimeImmutable  $created_at            = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    private ?User               $created_by            = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private                     $image;

    #[UploadableField(mapping: 'event', fileNameProperty: 'image')]
    private                     $imageFile;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $updated_at            = null;

    #[ORM\Column]
    #[Assert\NotNull]
    private ?bool               $is_private            = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[Assert\NotBlank]
    private ?Type               $type                  = null;

    #[ORM\Column(nullable: true)]
    private ?array              $availableFor          = [];

    #[ORM\Column(length: 255, nullable: true)]
    private ?string             $location              = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string             $theme                 = null;

    #[ORM\Column(nullable: true)]
    private ?array              $extraInfoOrganisation = [];

    #[ORM\Column]
    private ?bool               $is_finished           = null;

    public function __construct()
    {
        $this->rrule = new RRule();
        $now         = (new DateTime('+1 hour'));
        $now->setTime(21, 30);
        $this->start_at    = $now;
        $this->duration    = new DateInterval('PT2H0M');
        $this->dates       = new ArrayCollection();
        $this->created_at  = new DateTimeImmutable('NOW');
        $this->updated_at  = new DateTimeImmutable('NOW');
        $this->has_rrule   = false;
        $this->is_private  = false;
        $this->is_finished = false;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getStartAt(): ?DateTimeInterface
    {
        return $this->start_at;
    }

    public function setStartAt(DateTimeInterface $start_at): self
    {
        $this->start_at = $start_at;

        return $this;
    }


    public function getEndAt(): ?DateTimeInterface
    {
        return $this->end_at;
    }

    public function setEndAt(?DateTimeInterface $end_at): Event
    {
        $this->end_at = $end_at;
        return $this;
    }

    public function getDuration(): ?DateInterval
    {
        return $this->duration;
    }

    public function setDuration(DateInterval $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getRrule(): ?RRule
    {
        return $this->rrule;
    }

    public function setRrule(?RRule $rrule): self
    {
        $this->rrule = $rrule;

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

    public function isHasRrule(): ?bool
    {
        return $this->has_rrule;
    }

    public function setHasRrule(bool $has_rrule): self
    {
        $this->has_rrule = $has_rrule;

        return $this;
    }

    /**
     * @return Collection|Date[]
     */
    public function getDates(): Collection|array
    {
        return $this->dates;
    }

    public function setDates(array $dates): self
    {
        $this->dates = new ArrayCollection($dates);
        return $this;
    }

    public function addDate(Date $date): self
    {
        if (!$this->dates->contains($date)) {
            $this->dates->add($date);
            $date->setEvent($this);
        }

        return $this;
    }

    public function removeDate(Date $date): self
    {
        if ($this->dates->removeElement($date)) {
            // set the owning side to null (unless already changed)
            if ($date->getEvent() === $this) {
                $date->setEvent(null);
            }
        }

        return $this;
    }

    public function clearDates(): self
    {
        foreach ($this->getDates() as $date) {
            $this->removeDate($date);
        }
        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->created_by;
    }

    public function setCreatedBy(?User $created_by): self
    {
        $this->created_by = $created_by;

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

    public function getDefaultImage()
    {
        return EventTypes::getImage($this->type);
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

    public function isIsPrivate(): ?bool
    {
        return $this->is_private;
    }

    public function setIsPrivate(bool $is_private): self
    {
        $this->is_private = $is_private;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getAvailableFor(): array
    {
        return $this->availableFor;
    }


    public function getAvailableForLabel(): array
    {
        return EventAvailableForHelper::getLabels($this->availableFor);
    }

    public function setAvailableFor(?array $availableFor = []): self
    {
        $this->availableFor = $availableFor;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getTheme(): ?string
    {
        return $this->theme;
    }

    public function setTheme(?string $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    public function getExtraInfoOrganisation(): ?array
    {
        return $this->extraInfoOrganisation;
    }

    public function setExtraInfoOrganisation(?array $extraInfoOrganisation): Event
    {
        $this->extraInfoOrganisation = $extraInfoOrganisation;
        return $this;
    }

    public function isIsFinished(): ?bool
    {
        return $this->is_finished;
    }

    public function setIsFinished(bool $is_finished): self
    {
        $this->is_finished = $is_finished;

        return $this;
    }
}
