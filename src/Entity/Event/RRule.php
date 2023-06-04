<?php

namespace App\Entity\Event;

use App\Repository\Event\RRuleRepository;
use App\Service\Event\RRuleEntityToArrayConf;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\RRule as AssertRRule;

// https://github.com/rlanvin/php-rrule/wiki/RRule

#[ORM\Entity(repositoryClass: RRuleRepository::class)]
#[ORM\Table(name: 'event_rrule')]
class RRule
{

    public const FREQ_YEARLY   = "YEARLY";
    public const FREQ_MONTHLY  = "MONTHLY";
    public const FREQ_WEEKLY   = "WEEKLY";
    public const FREQ_DAILY    = "DAILY";
    public const FREQ_HOURLY   = "HOURLY";
    public const FREQ_MINUTELY = "MINUTELY";
    public const FREQ_SECONDLY = "SECONDLY";

    public const AVAILABLE_FREQ = [self::FREQ_YEARLY, self::FREQ_MONTHLY, self::FREQ_WEEKLY, self::FREQ_DAILY, self::FREQ_HOURLY, self::FREQ_MINUTELY, self::FREQ_SECONDLY,];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int      $id                 = null;

    #[ORM\Column]
    private ?bool     $isInfinite         = null;

    #[ORM\Column(length: 255)]
    #[Assert\Choice(choices: self::AVAILABLE_FREQ, message: 'Choisis une fréquence valide')]
    private ?string   $FREQUENCY          = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Type("DateTime")]
    private ?DateTime $DTSTART            = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Positive]
    private ?int      $FREQUENCY_INTERVAL = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Choice(choices: ['MO', 'TU', 'WE', 'TH', 'FR', 'SA', 'SU'], message: 'Choisis une valeur valide')]
    private ?string   $WKST               = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Positive]
    private ?int      $COUNT              = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Type("DateTime")]
    private ?DateTime $UNTIL              = null;

    #[ORM\Column(nullable: true)]
    private array     $BYMONTH            = [];

    #[ORM\Column(nullable: true)]
    private array     $BYWEEKNO           = [];

    #[ORM\Column(nullable: true)]
    private array     $BYYEARDAY          = [];

    #[ORM\Column(nullable: true)]
    private array     $BYMONTHDAY         = [];

    #[ORM\Column(nullable: true)]
    #[AssertRRule\BYDAY]
    private array     $BYDAY              = [];

    #[ORM\Column(nullable: true)]
    private array     $BYHOUR             = [];

    #[ORM\Column(nullable: true)]
    private array     $BYMINUTE           = [];

    #[ORM\Column(nullable: true)]
    private array     $BYSECOND           = [];

    #[ORM\Column(nullable: true)]
    private array     $BYSETPOS           = [];

    public function __construct()
    {
        $this->isInfinite = false;
        $now              = (new DateTime('+1 hour'));
        $now->setTime(21, 30);
        $this->DTSTART = $now;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return bool|null
     */
    public function getIsInfinite(): ?bool
    {
        return $this->isInfinite;
    }

    /**
     * @param bool|null $isInfinite
     * @return RRule
     */
    public function setIsInfinite(?bool $isInfinite): RRule
    {
        $this->isInfinite = $isInfinite;
        return $this;
    }

    public function __toString()
    {
        return $this->getRRuleObject()->humanReadable();
    }

    public function getRRuleObject(): \RRule\RRule
    {
        return (new \RRule\RRule(RRuleEntityToArrayConf::getConf($this)));
    }

    public function getOccurences(): array
    {
        $rruleObject = $this->getRRuleObject();
        return $rruleObject->getOccurrences($rruleObject->isInfinite() ? 20 : null);
    }

    /**
     * @return string|null
     */
    public function getFREQUENCY(): ?string
    {
        return $this->FREQUENCY;
    }

    /**
     * @param string|null $FREQUENCY
     * @return RRule
     */
    public function setFREQUENCY(?string $FREQUENCY): RRule
    {
        $this->FREQUENCY = $FREQUENCY;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getDTSTART(): ?DateTime
    {
        return $this->DTSTART;
    }

    /**
     * @param DateTime|null $DTSTART
     * @return RRule
     */
    public function setDTSTART(?DateTime $DTSTART): RRule
    {
        $this->DTSTART = $DTSTART;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getFREQUENCYINTERVAL(): ?int
    {
        return $this->FREQUENCY_INTERVAL;
    }

    /**
     * @param int|null $FREQUENCY_INTERVAL
     * @return RRule
     */
    public function setFREQUENCYINTERVAL(?int $FREQUENCY_INTERVAL): RRule
    {
        $this->FREQUENCY_INTERVAL = $FREQUENCY_INTERVAL;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getWKST(): ?string
    {
        return $this->WKST;
    }

    /**
     * @param string|null $WKST
     * @return RRule
     */
    public function setWKST(?string $WKST): RRule
    {
        $this->WKST = $WKST;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCOUNT(): ?int
    {
        return $this->COUNT;
    }

    /**
     * @param int|null $COUNT
     * @return RRule
     */
    public function setCOUNT(?int $COUNT): RRule
    {
        $this->COUNT = $COUNT;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getUNTIL(): ?DateTime
    {
        return $this->UNTIL;
    }

    /**
     * @param DateTime|null $UNTIL
     * @return RRule
     */
    public function setUNTIL(?DateTime $UNTIL): RRule
    {
        $this->UNTIL = $UNTIL;
        return $this;
    }

    /**
     * @return array
     */
    public function getBYMONTH(): array
    {
        return $this->BYMONTH;
    }

    /**
     * @param array $BYMONTH
     * @return RRule
     */
    public function setBYMONTH(array $BYMONTH): RRule
    {
        $this->BYMONTH = $BYMONTH;
        return $this;
    }

    /**
     * @return array
     */
    public function getBYWEEKNO(): array
    {
        return $this->BYWEEKNO;
    }

    /**
     * @param array $BYWEEKNO
     * @return RRule
     */
    public function setBYWEEKNO(array $BYWEEKNO): RRule
    {
        $this->BYWEEKNO = $BYWEEKNO;
        return $this;
    }

    /**
     * @return array
     */
    public function getBYYEARDAY(): array
    {
        return $this->BYYEARDAY;
    }

    /**
     * @param array $BYYEARDAY
     * @return RRule
     */
    public function setBYYEARDAY(array $BYYEARDAY): RRule
    {
        $this->BYYEARDAY = $BYYEARDAY;
        return $this;
    }

    /**
     * @return array
     */
    public function getBYMONTHDAY(): array
    {
        return $this->BYMONTHDAY;
    }

    /**
     * @param array $BYMONTHDAY
     * @return RRule
     */
    public function setBYMONTHDAY(array $BYMONTHDAY): RRule
    {
        $this->BYMONTHDAY = $BYMONTHDAY;
        return $this;
    }

    /**
     * @return array
     */
    public function getBYDAY(): array
    {
        return $this->BYDAY;
    }

    /**
     * @param array $BYDAY
     * @return RRule
     */
    public function setBYDAY(array $BYDAY): RRule
    {
        $this->BYDAY = $BYDAY;
        return $this;
    }

    /**
     * @return array
     */
    public function getBYHOUR(): array
    {
        return $this->BYHOUR;
    }

    /**
     * @param array $BYHOUR
     * @return RRule
     */
    public function setBYHOUR(array $BYHOUR): RRule
    {
        $this->BYHOUR = $BYHOUR;
        return $this;
    }

    /**
     * @return array
     */
    public function getBYMINUTE(): array
    {
        return $this->BYMINUTE;
    }

    /**
     * @param array $BYMINUTE
     * @return RRule
     */
    public function setBYMINUTE(array $BYMINUTE): RRule
    {
        $this->BYMINUTE = $BYMINUTE;
        return $this;
    }

    /**
     * @return array
     */
    public function getBYSECOND(): array
    {
        return $this->BYSECOND;
    }

    /**
     * @param array $BYSECOND
     * @return RRule
     */
    public function setBYSECOND(array $BYSECOND): RRule
    {
        $this->BYSECOND = $BYSECOND;
        return $this;
    }

    /**
     * @return array
     */
    public function getBYSETPOS(): array
    {
        return $this->BYSETPOS;
    }

    /**
     * @param array $BYSETPOS
     * @return RRule
     */
    public function setBYSETPOS(array $BYSETPOS): RRule
    {
        $this->BYSETPOS = $BYSETPOS;
        return $this;
    }
}
