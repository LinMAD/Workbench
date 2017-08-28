<?php

namespace CarBundle\DataFixtures\ORM;

use CarBundle\Entity\Car;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadCars extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder(): int
    {
        return 2;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $carsAndModels = [
            [
                'model' => $this->getReference('X1'),
                'make' => $this->getReference('BMW'),
                'price' => 100500,
                'year' => 2017,
                'navigation' => false,
                'promote'    => true,
            ],
            [
                'model' => $this->getReference('Passat'),
                'make' => $this->getReference('VW'),
                'price' => 500100,
                'year' => 2017,
                'navigation' => true,
                'promote'    => true,
            ],
        ];

        foreach ($carsAndModels as $car) {
            $carEntity = new Car();

            foreach ($car as $details => $value) {
                echo $value;
                switch ($details) {
                    case 'model':
                        // Reference will be
                        $carEntity->setModel($value);
                        break;
                    case 'make':
                        // Reference will be
                        $carEntity->setMake($value);
                        break;
                    case 'price':
                        $carEntity->setPrice($value);
                        break;
                    case 'year':
                        $carEntity->setYear($value);
                        break;
                    case 'navigation':
                        $carEntity->setNavigation($value);
                        break;
                    case 'promote':
                        $carEntity->setPromote($value);
                        break;
                    default:
                        break;
                }
            }

            $manager->persist($carEntity);
        }

        $manager->flush();
    }
}