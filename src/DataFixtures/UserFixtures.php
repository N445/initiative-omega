<?php

namespace App\DataFixtures;

use App\Entity\Rsi\Ship\Ship;
use App\Entity\User;
use App\Service\Rsi\RsiShipProvider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private RsiShipProvider             $rsiShipProvider;

    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(
        RsiShipProvider             $rsiShipProvider,
        UserPasswordHasherInterface $userPasswordHasher
    )
    {
        $this->rsiShipProvider    = $rsiShipProvider;
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $ships    = $this->rsiShipProvider->getShips();
        $shipsIds = array_map(fn(Ship $ship) => $ship->getRsiId(), $ships);

        $faker = Factory::create('fr_FR');

        $admins = ['parisrob@hotmail.fr', 'shadow-of-caliban@gmail.com'];
        foreach ($admins as $admin) {
            $user = new User();
            $user
                ->setEmail($admin)
                ->setRoles(['ROLE_ADMIN'])
                ->setPassword($this->userPasswordHasher->hashPassword($user, $admin))
                ->setIsVerified(true)
                ->setInfo(new User\Info())
            ;

            $fleets = $this->getFleets($shipsIds, $faker);
            foreach ($fleets as $fleet) {
                $user->addFleet($fleet);
            }
            $manager->persist($user);
        }
        $manager->flush();

        foreach (range(1, 100) as $i) {
            $email = $faker->email();

            $info = new User\Info();
            $info
                ->setRsiName($faker->optional()->userName())
                ->setGuildedName($faker->optional()->userName())
                ->setDiscordName($faker->optional()->userName())
            ;

            $user = new User();
            $user
                ->setEmail($email)
//                ->setRoles()
                ->setPassword($this->userPasswordHasher->hashPassword($user, $email))
                ->setIsVerified($faker->boolean())
                ->setRegisteredAt(new \DateTimeImmutable($faker->dateTimeBetween('-60 days', '-30 days')->format(DATE_ATOM)))
                ->setLastloginAt(new \DateTimeImmutable($faker->dateTimeBetween('-29 days', 'now')->format(DATE_ATOM)))
                ->setInfo($info)
            ;

            $fleets = $this->getFleets($shipsIds, $faker);
            foreach ($fleets as $fleet) {
                $user->addFleet($fleet);
            }
            $manager->persist($user);
            if ($i % 10 === 0) {
                $manager->flush();
            }
        }

        $manager->flush();
    }

    /**
     * @param array     $shipsIds
     * @param Generator $faker
     * @return User\Fleet[]
     */
    private function getFleets(array $shipsIds, Generator $faker): array
    {
        $fleets = [];

        foreach (range(1, rand(2, 20)) as $item) {
            /** @var Ship $ship */
            $ship  = $this->getReference(sprintf(ShipFixtures::REFERENCE, $faker->randomElement($shipsIds)));
            $fleet = new User\Fleet();
            $fleet
                ->setShip($ship)
                ->setNumberShips($faker->numberBetween(1, 4))
                ->setIsBuyInGame($faker->boolean)
            ;
            $fleets[] = $fleet;
        }
        return $fleets;
    }

    public function getDependencies()
    {
        return [
            ShipFixtures::class,
        ];
    }
}
