<?php

namespace App\Entity\Rsi\Ship\Ship;

use App\Repository\Rsi\Ship\Ship\AvionicRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AvionicRepository::class)]
#[ORM\Table(name: 'ship_info_propulsion')]
class Propulsion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'propulsion', targetEntity: Component::class, cascade: ['persist', 'remove'])]
    private Collection $components;

    public function __construct()
    {
        $this->components = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Component>
     */
    public function getComponents(): Collection
    {
        return $this->components;
    }

    public function addComponent(Component $component): self
    {
        if (!$this->components->contains($component)) {
            $this->components->add($component);
            $component->setPropulsion($this);
        }

        return $this;
    }

    public function removeComponent(Component $component): self
    {
        if ($this->components->removeElement($component)) {
            // set the owning side to null (unless already changed)
            if ($component->getPropulsion() === $this) {
                $component->setPropulsion(null);
            }
        }

        return $this;
    }
}
