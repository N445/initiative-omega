<?php

namespace App\Entity;

use App\Repository\ActivityRepository;
use Doctrine\Inflector\InflectorFactory;
use Doctrine\Inflector\Language;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ActivityRepository::class)]
#[Vich\Uploadable]
#[ORM\HasLifecycleCallbacks]
class Activity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private      $id;

    #[ORM\Column(type: 'datetime_immutable')]
    private      $created_at;

    #[ORM\Column(type: 'datetime_immutable')]
    private      $updated_at;

    #[ORM\Column(type: 'string', length: 255)]
    private      $title;

    #[ORM\Column(type: 'text', nullable: true)]
    private      $content;

    #[ORM\Column(type: 'string', length: 255)]
    private      $image;

    #[UploadableField(mapping: 'activity', fileNameProperty: 'image')]
    private      $imageFile;

    #[ORM\Column]
    private ?int $displayOrder = null;

    #[ORM\Column]
    private ?bool $isActive = true;

    public function __construct()
    {
        $this->created_at   = new \DateTimeImmutable('NOW');
        $this->displayOrder = 10;
    }

    #[Orm\PostUpdate]
    public function onUpdate()
    {
        $this->updated_at = new \DateTimeImmutable('now');
    }

    public function getSlug()
    {
        $inflector = InflectorFactory::createForLanguage(Language::FRENCH);
        return $inflector->build()->urlize($this->title);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at)
    {
        $this->updated_at = $updated_at;
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
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
            $this->updated_at = new \DateTimeImmutable('now');
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

    public function getDisplayOrder(): ?int
    {
        return $this->displayOrder;
    }

    public function setDisplayOrder(int $displayOrder): self
    {
        $this->displayOrder = $displayOrder;

        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }
}
