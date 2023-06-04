<?php

namespace App\Admin\Field;

use App\Entity\Event\RRule;
use App\Form\Event\RRuleType;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

final class EventTypeField implements FieldInterface
{
    use FieldTrait;

    public const OPTION_CHOICES = 'choices';

    /**
     * @param string|false|null $label
     */
    public static function new(string $propertyName, $label = null): self
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setTemplateName('crud/field/choice')
            ->setFormType(ChoiceType::class)
            ->addCssClass('field-select')
            ->setCustomOption(self::OPTION_CHOICES, null)
            ->setCustomOption('attr', ['data-widget' => 'select2']);
        ;
    }

    public function setChoices($choiceGenerator): self
    {
        if (!\is_array($choiceGenerator) && !\is_callable($choiceGenerator)) {
            throw new \InvalidArgumentException(sprintf('The argument of the "%s" method must be an array or a closure ("%s" given).', __METHOD__, \gettype($choiceGenerator)));
        }

        $this->setCustomOption(self::OPTION_CHOICES, $choiceGenerator);

        return $this;
    }
}
