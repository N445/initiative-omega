<?php

namespace App\Service\Init;

use App\Entity\Role;
use Doctrine\ORM\EntityManagerInterface;

class RoleInit
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @return void
     */
    public function init(): void
    {
        foreach ($this->getData() as $datum) {
            $this->em->persist($datum);
        }
        $this->em->flush();
    }

    /**
     * @return Role[]
     */
    private function getData(): array
    {
        return [
            (new Role())->setTitle('Ambassadeur')->setDisplayOrder(10)->setDescription("En tant qu'Ambassadeur, il vous est possible d’accéder à la zone publique du \"Merchantman(Commerce de la Flotte)\" et d'accèder à ┃ Ambassade, la suite dépendra de votre relation avec le syndicat."),
            (new Role())->setTitle('Partenaire')->setDisplayOrder(20)->setDescription("En tant que partenaire, il vous est possible d’accéder à la zone publique du \"Merchantman(Commerce de la Flotte)\" et il vous est possible de participer aux événements organisés par le syndicat, votre organisation respective et de bénéficier d'une répartition des richesses en accord avec le contrat de partenariat signé avec votre organisation."),
            (new Role())->setTitle('Citizen')->setDisplayOrder(30)->setDescription("En tant que citoyen, il vous est possible d’accéder à la zone publique du \"Merchantman(Commerce de la Flotte)\" et il vous est possible de participer aux événements publics organisés par le syndicat, de bénéficier d'une répartition des richesses équitable."),
            (new Role())->setTitle('Freelance')->setDisplayOrder(40)->setDescription("En tant que freelance, il vous est possible d’accéder à la zone publique du \"Merchantman(Commerce de la Flotte)\" et il vous est possible de participer aux événements publics, d'une répartition des richesses dégressif suivant la performance, le rôle joué et la relation qu'entretenu avec le syndicat. Il est possible qu'un freelance propose ses tarifs, mais ceux-ci devront être forcément acceptés par les deux parties en amont de l'action, si ce n'est pas le cas, c'est le premier mode de fonctionnement qui sera utilisé."),
        ];
    }
}
