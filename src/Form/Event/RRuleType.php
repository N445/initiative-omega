<?php

namespace App\Form\Event;

use App\Entity\Event\RRule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RRuleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('FREQUENCY', ChoiceType::class, [
                'label'   => 'Récurence',
                'choices' => [
                    'Tout les ans'       => RRule::FREQ_YEARLY,
                    'Tout les mois'      => RRule::FREQ_MONTHLY,
                    'Toute les semaines' => RRule::FREQ_WEEKLY,
                    'Tout les jours'     => RRule::FREQ_DAILY,
                    'Toute les heures'   => RRule::FREQ_HOURLY,
                ],
            ])
            ->add('DTSTART', DateTimeType::class, [
                'label'  => 'Date de début',
                'help'   => 'La date et l\'heure de début de la récurrence .',
                'widget' => 'single_text',
            ])
            ->add('FREQUENCY_INTERVAL', IntegerType::class, [
                'label' => 'Intervale',
                'help'  => 'L\'intervalle entre chaque itération de "Récurence".',
            ])
            ->add('WKST', ChoiceType::class, [
                'label'   => 'Début de la récurence',
                'help'    => 'Le jour du début de la semaine.',
                'choices' => [
                    'Lundi'    => 'MO',
                    'Mardi'    => 'TU',
                    'Mercredi' => 'WE',
                    'Jeudi'    => 'TH',
                    'Vendredi' => 'FR',
                    'Samedi'   => 'SA',
                    'Dimanche' => 'SU',
                ],
            ])
            ->add('COUNT', IntegerType::class, [
                'label'    => 'Nombre de récurence',
                'help'     => 'Combien d\'occurrences seront générées.',
                'required' => false,
                'attr'     => [
                    'min' => 1,
                ],
            ])
            ->add('UNTIL', DateTimeType::class, [
                'label'  => 'Date de fin',
                'help'   => 'La limite de la récurrence.',
                'widget' => 'single_text',
            ])
            ->add('BYMONTH', TextType::class, [
                'label' => 'A appliquer sur les mois',
                'help'  => 'Le ou les mois auxquels appliquer la récurrence, du 1er (janvier) au 12 (décembre). Il peut s\'agir d\'une valeur unique ou d\'une liste séparée par des virgules.',
            ])
            ->add('BYWEEKNO', TextType::class, [
                'label' => 'A appliquer sur les semaines',
                'help'  => 'Le ou les numéros de semaine auxquels appliquer la récurrence, de 1 à 53 ou de -53 à -1. Les valeurs négatives signifient que le comptage commence à la fin de l\'année, ainsi -1 signifie "la dernière semaine de l\'année". Les numéros de semaine ont la signification décrite dans la norme ISO8601, c\'est-à-dire que la première semaine de l\'année est celle qui contient au moins quatre jours de la nouvelle année. Les numéros de semaine sont affectés par le paramètre WKST. Il peut s\'agir d\'une valeur unique ou d\'une liste séparée par des virgules. Attention : les numéros de semaine négatifs ne sont pas encore complètement testés.',
            ])
            ->add('BYYEARDAY', TextType::class, [
                'label' => 'A appliquer sur les jours de l\'année',
                'help'  => 'Le ou les jours de l\'année auxquels appliquer la récurrence, de 1 à 366 ou de -366 à -1. Les valeurs négatives signifient que le comptage commence à la fin de l\'année, donc -1 signifie "le dernier jour de l\'année". Il peut s\'agir d\'une valeur unique ou d\'une liste séparée par des virgules.',
            ])
            ->add('BYMONTHDAY', TextType::class, [
                'label' => 'A appliquer sur les jours du mois',
                'help'  => 'Le ou les jours du mois auxquels appliquer la récurrence, de 1 à 31 ou de -31 à -1. Les valeurs négatives signifient que le comptage commence à la fin du mois, donc -1 signifie "le dernier jour du mois". Il peut s\'agir d\'une valeur unique ou d\'une liste séparée par des virgules.',
            ])
            ->add('BYDAY', TextType::class, [
                'label' => 'A appliquer sur les jours',
                'help'  => 'Le(s) jour(s) de la semaine auquel(s) appliquer la récurrence parmi les suivants : MO, TU, WE, TH, FR, SA, SU. Il peut s\'agir d\'une valeur unique ou d\'une liste séparée par des virgules. Chaque jour peut être précédé d\'un nombre, indiquant une occurrence spécifique dans l\'intervalle. Par exemple : 1MO (le premier lundi de l\'intervalle), 3MO (le troisième lundi), -1MO (le dernier lundi), et ainsi de suite.',
            ])
//            ->add('BYDAY', ChoiceType::class, [
//                'label'    => 'A appliquer sur les jours',
//                'help'     => 'Le(s) jour(s) de la semaine auquel(s) appliquer la récurrence parmi les suivants : LUN, TU, WE, TH, FR, SA, SU. Il peut s\'agir d\'une valeur unique ou d\'une liste séparée par des virgules. Chaque jour peut être précédé d\'un nombre, indiquant une occurrence spécifique dans l\'intervalle. Par exemple : 1MO (le premier lundi de l\'intervalle), 3MO (le troisième lundi), -1MO (le dernier lundi), et ainsi de suite.',
//                'multiple' => true,
//                'expanded' => true,
//                'choices'  => [
//                    'Lundi'    => 'MO',
//                    'Mardi'    => 'TU',
//                    'Mercredi' => 'WE',
//                    'Jeudi'    => 'TH',
//                    'Vendredi' => 'FR',
//                    'Samedi'   => 'SA',
//                    'Dimanche' => 'SU',
//                ],
//            ])
//            ->add('BYHOUR')
//            ->add('BYMINUTE')
//            ->add('BYSECOND')
//            ->add('BYSETPOS')
        ;

        $builder->get('BYMONTH')->addModelTransformer(new CallbackTransformer(
            function ($array) {
                return implode(',', $array);
            },
            function ($string) {
                $data = array_filter(explode(',', $string));
                array_walk($data, 'trim');
                return $data;
            }));

        $builder->get('BYWEEKNO')->addModelTransformer(new CallbackTransformer(
            function ($array) {
                return implode(',', $array);
            },
            function ($string) {
                $data = array_filter(explode(',', $string));
                array_walk($data, 'trim');
                return $data;
            }));

        $builder->get('BYYEARDAY')->addModelTransformer(new CallbackTransformer(
            function ($array) {
                return implode(',', $array);
            },
            function ($string) {
                $data = array_filter(explode(',', $string));
                array_walk($data, 'trim');
                return $data;
            }));

        $builder->get('BYMONTHDAY')->addModelTransformer(new CallbackTransformer(
            function ($array) {
                return implode(',', $array);
            },
            function ($string) {
                $data = array_filter(explode(',', $string));
                array_walk($data, 'trim');
                return $data;
            }));

        $builder->get('BYDAY')->addModelTransformer(new CallbackTransformer(
            function ($array) {
                return implode(',', $array);
            },
            function ($string) {
                $data = array_filter(explode(',', $string));
                array_walk($data, 'trim');
                return $data;
            }));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RRule::class,
        ]);
    }

    private function stringToArray(string $string)
    {
        return explode(', ', $string);
    }

    private function arrayTostring(array $array)
    {
        return implode(', ', $array);
    }
}
