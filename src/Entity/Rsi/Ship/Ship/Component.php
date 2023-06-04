<?php

namespace App\Entity\Rsi\Ship\Ship;

use App\Repository\Rsi\Ship\Ship\AvionicRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AvionicRepository::class)]
#[ORM\Table(name: 'ship_info_component')]
class Component
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int        $id              = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string     $type            = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string     $name            = null;

    #[ORM\Column]
    private ?int        $mounts          = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string     $component_size  = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string     $size            = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string     $details         = null;

    #[ORM\Column(nullable: true)]
    private ?int        $quantity        = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string     $manufacturer    = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string     $component_class = null;

    #[ORM\ManyToOne(inversedBy: 'components')]
    private ?Avionic    $avionic         = null;

    #[ORM\ManyToOne(inversedBy: 'components')]
    private ?Modular    $modular         = null;

    #[ORM\ManyToOne(inversedBy: 'components')]
    private ?Propulsion $propulsion      = null;

    #[ORM\ManyToOne(inversedBy: 'components')]
    private ?Thruster   $thruster        = null;

    #[ORM\ManyToOne(inversedBy: 'components')]
    private ?Weapon     $weapon          = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return Component
     */
    public function setType(?string $type): Component
    {
        $this->type = $type;
        return $this;
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
     * @return Component
     */
    public function setName(?string $name): Component
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMounts(): ?int
    {
        return $this->mounts;
    }

    /**
     * @param int|null $mounts
     * @return Component
     */
    public function setMounts(?int $mounts): Component
    {
        $this->mounts = $mounts;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getComponentSize(): ?string
    {
        return $this->component_size;
    }

    /**
     * @param string|null $component_size
     * @return Component
     */
    public function setComponentSize(?string $component_size): Component
    {
        $this->component_size = $component_size;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSize(): ?string
    {
        return $this->size;
    }

    /**
     * @param string|null $size
     * @return Component
     */
    public function setSize(?string $size): Component
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDetails(): ?string
    {
        return $this->details;
    }

    /**
     * @param string|null $details
     * @return Component
     */
    public function setDetails(?string $details): Component
    {
        $this->details = $details;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * @param int|null $quantity
     * @return Component
     */
    public function setQuantity(?int $quantity): Component
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getManufacturer(): ?string
    {
        return $this->manufacturer;
    }

    /**
     * @param string|null $manufacturer
     * @return Component
     */
    public function setManufacturer(?string $manufacturer): Component
    {
        $this->manufacturer = $manufacturer;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getComponentClass(): ?string
    {
        return $this->component_class;
    }

    /**
     * @param string|null $component_class
     * @return Component
     */
    public function setComponentClass(?string $component_class): Component
    {
        $this->component_class = $component_class;
        return $this;
    }

    /**
     * @return Avionic|null
     */
    public function getAvionic(): ?Avionic
    {
        return $this->avionic;
    }

    /**
     * @param Avionic|null $avionic
     * @return Component
     */
    public function setAvionic(?Avionic $avionic): Component
    {
        $this->avionic = $avionic;
        return $this;
    }

    /**
     * @return Modular|null
     */
    public function getModular(): ?Modular
    {
        return $this->modular;
    }

    /**
     * @param Modular|null $modular
     * @return Component
     */
    public function setModular(?Modular $modular): Component
    {
        $this->modular = $modular;
        return $this;
    }

    /**
     * @return Propulsion|null
     */
    public function getPropulsion(): ?Propulsion
    {
        return $this->propulsion;
    }

    /**
     * @param Propulsion|null $propulsion
     * @return Component
     */
    public function setPropulsion(?Propulsion $propulsion): Component
    {
        $this->propulsion = $propulsion;
        return $this;
    }

    /**
     * @return Thruster|null
     */
    public function getThruster(): ?Thruster
    {
        return $this->thruster;
    }

    /**
     * @param Thruster|null $thruster
     * @return Component
     */
    public function setThruster(?Thruster $thruster): Component
    {
        $this->thruster = $thruster;
        return $this;
    }

    /**
     * @return Weapon|null
     */
    public function getWeapon(): ?Weapon
    {
        return $this->weapon;
    }

    /**
     * @param Weapon|null $weapon
     * @return Component
     */
    public function setWeapon(?Weapon $weapon): Component
    {
        $this->weapon = $weapon;
        return $this;
    }

}
