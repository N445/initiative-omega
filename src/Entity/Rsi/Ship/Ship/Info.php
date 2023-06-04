<?php

namespace App\Entity\Rsi\Ship\Ship;

use App\Repository\Rsi\Ship\Ship\InfoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InfoRepository::class)]
#[ORM\Table(name: 'ship_info')]
class Info
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int                $id                 = null;

    #[ORM\Column(nullable: true)]
    private ?int                $afterburner_speed  = null;

    #[ORM\Column(nullable: true)]
    private ?float              $beam               = null;

    #[ORM\Column(nullable: true)]
    private ?int                $cargocapacity      = null;

    #[ORM\Column]
    private ?int                $chassis_id         = null;

    #[ORM\Column]
    private ?float              $height             = null;

    #[ORM\Column]
    private ?float              $length             = null;

    #[ORM\Column(nullable: true)]
    private ?int                $mass               = null;

    #[ORM\Column(nullable: true)]
    private ?int                $max_crew           = null;

    #[ORM\Column(nullable: true)]
    private ?int                $min_crew           = null;

    #[ORM\Column(nullable: true)]
    private ?float              $pitch_max          = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string             $production_note    = null;

    #[ORM\Column(length: 255)]
    private ?string             $production_status  = null;

    #[ORM\Column(nullable: true)]
    private ?float              $roll_max           = null;

    #[ORM\Column(nullable: true)]
    private ?int                $scm_speed          = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string             $size               = null;

    #[ORM\Column]
    private ?\DateInterval      $time_modified      = null;

    #[ORM\Column(length: 255)]
    private ?string             $type               = null;

    #[ORM\Column(nullable: true)]
    private ?float              $xaxis_acceleration = null;

    #[ORM\Column(nullable: true)]
    private ?float              $yaw_max            = null;

    #[ORM\Column(nullable: true)]
    private ?float              $yaxis_acceleration = null;

    #[ORM\Column(nullable: true)]
    private ?float              $zaxis_acceleration = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string             $description        = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $time_modified_date = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Avionic            $avionic            = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Modular            $modular            = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Propulsion         $propulsion         = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Thruster           $thruster           = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Weapon             $weapon             = null;

    public function __construct()
    {
        $this->avionic    = new Avionic();
        $this->modular    = new Modular();
        $this->propulsion = new Propulsion();
        $this->thruster   = new Thruster();
        $this->weapon     = new Weapon();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAfterburnerSpeed(): ?int
    {
        return $this->afterburner_speed;
    }

    public function setAfterburnerSpeed(?int $afterburner_speed): self
    {
        $this->afterburner_speed = $afterburner_speed;

        return $this;
    }

    public function getBeam(): ?float
    {
        return $this->beam;
    }

    public function setBeam(?float $beam): self
    {
        $this->beam = $beam;

        return $this;
    }

    public function getCargocapacity(): ?int
    {
        return $this->cargocapacity;
    }

    public function setCargocapacity(?int $cargocapacity): self
    {
        $this->cargocapacity = $cargocapacity;

        return $this;
    }

    public function getChassisId(): ?int
    {
        return $this->chassis_id;
    }

    public function setChassisId(int $chassis_id): self
    {
        $this->chassis_id = $chassis_id;

        return $this;
    }

    public function getHeight(): ?float
    {
        return $this->height;
    }

    public function setHeight(float $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getLength(): ?float
    {
        return $this->length;
    }

    public function setLength(float $length): self
    {
        $this->length = $length;

        return $this;
    }

    public function getMass(): ?int
    {
        return $this->mass;
    }

    public function setMass(?int $mass): self
    {
        $this->mass = $mass;

        return $this;
    }

    public function getMaxCrew(): ?int
    {
        return $this->max_crew;
    }

    public function setMaxCrew(?int $max_crew): self
    {
        $this->max_crew = $max_crew;

        return $this;
    }

    public function getMinCrew(): ?int
    {
        return $this->min_crew;
    }

    public function setMinCrew(?int $min_crew): self
    {
        $this->min_crew = $min_crew;

        return $this;
    }

    public function getPitchMax(): ?float
    {
        return $this->pitch_max;
    }

    public function setPitchMax(?float $pitch_max): self
    {
        $this->pitch_max = $pitch_max;

        return $this;
    }

    public function getProductionNote(): ?string
    {
        return $this->production_note;
    }

    public function setProductionNote(?string $production_note): self
    {
        $this->production_note = $production_note;

        return $this;
    }

    public function getProductionStatus(): ?string
    {
        return $this->production_status;
    }

    public function setProductionStatus(string $production_status): self
    {
        $this->production_status = $production_status;

        return $this;
    }

    public function getRollMax(): ?float
    {
        return $this->roll_max;
    }

    public function setRollMax(?float $roll_max): self
    {
        $this->roll_max = $roll_max;

        return $this;
    }

    public function getScmSpeed(): ?int
    {
        return $this->scm_speed;
    }

    public function setScmSpeed(?int $scm_speed): self
    {
        $this->scm_speed = $scm_speed;

        return $this;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(?string $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getTimeModified(): ?\DateInterval
    {
        return $this->time_modified;
    }

    public function setTimeModified(\DateInterval $time_modified): self
    {
        $this->time_modified = $time_modified;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getXaxisAcceleration(): ?float
    {
        return $this->xaxis_acceleration;
    }

    public function setXaxisAcceleration(?float $xaxis_acceleration): self
    {
        $this->xaxis_acceleration = $xaxis_acceleration;

        return $this;
    }

    public function getYawMax(): ?float
    {
        return $this->yaw_max;
    }

    public function setYawMax(?float $yaw_max): self
    {
        $this->yaw_max = $yaw_max;

        return $this;
    }

    public function getYaxisAcceleration(): ?float
    {
        return $this->yaxis_acceleration;
    }

    public function setYaxisAcceleration(?float $yaxis_acceleration): self
    {
        $this->yaxis_acceleration = $yaxis_acceleration;

        return $this;
    }

    public function getZaxisAcceleration(): ?float
    {
        return $this->zaxis_acceleration;
    }

    public function setZaxisAcceleration(?float $zaxis_acceleration): self
    {
        $this->zaxis_acceleration = $zaxis_acceleration;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTimeModifiedDate(): ?\DateTimeInterface
    {
        return $this->time_modified_date;
    }

    public function setTimeModifiedDate(\DateTimeInterface $time_modified_date): self
    {
        $this->time_modified_date = $time_modified_date;

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
     * @return Info
     */
    public function setAvionic(?Avionic $avionic): Info
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
     * @return Info
     */
    public function setModular(?Modular $modular): Info
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
     * @return Info
     */
    public function setPropulsion(?Propulsion $propulsion): Info
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
     * @return Info
     */
    public function setThruster(?Thruster $thruster): Info
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
     * @return Info
     */
    public function setWeapon(?Weapon $weapon): Info
    {
        $this->weapon = $weapon;
        return $this;
    }
}
