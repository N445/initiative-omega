<?php

namespace App\Form;

use App\Entity\Contact;
use App\Validator\Recaptcha;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\NotNull;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('typeContact', ChoiceType::class, [
                'label'    => 'Objet de votre message',
                //'placeholder' => 'Objet de votre message',
                'row_attr' => [
                    'class' => 'form-floating',
                ],
                'choices'  => [
                    'Objets' => array_combine(Contact::TYPE_CONTACTS, Contact::TYPE_CONTACTS),
                ],
            ])
            ->add('email', EmailType::class, [
                'label'       => 'Votre email',
                'attr'        => [
                    'placeholder' => 'Votre email',
                ],
                'row_attr'    => [
                    'class' => 'form-floating',
                ],
                'constraints' => [
                    new NotNull([], 'Ce champ est requis'),
                    new Email(),
                ],
            ])
            ->add('message', TextareaType::class, [
                'label'       => 'Votre message',
                'attr'        => [
                    'placeholder' => 'Votre message',
                    'rows'        => 10,
                    'style'       => 'height:200px;',
                ],
                'row_attr'    => [
                    'class' => 'form-floating',
                ],
                'constraints' => new NotNull([], 'Ce champ est requis'),
            ])
            ->add('rgpd', CheckboxType::class, [
                'label'       => 'Je reconnais avoir pris connaissance de la politique de confidentalité',
                'constraints' => new IsTrue([], 'Vous devez avoir pris connaissance de la politique de confidentalité'),
                'mapped'      => false,
                'required'    => true,
            ])
            ->add('captcha', HiddenType::class, [
                'constraints' => new Recaptcha(),
                'mapped'      => false,
                'attr'        => [
                    'class' => 'recaptcha',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
