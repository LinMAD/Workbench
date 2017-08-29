<?php

namespace CarBundle\DataFixtures\ORM;

use CarBundle\Entity\Make;
use CarBundle\Entity\Model;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadDictionary extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder(): int
    {
        return 1;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $makeNames = [
            'VW',
            'BMW',
            'Fiat',
        ];
        $this->loadToManager($manager, Make::class, $makeNames);

        $makeNames = [
            'X1',
            'Passat',
            'Chroma',
        ];
        $this->loadToManager($manager, Model::class, $makeNames);

        $manager->flush();
    }

    /**
     * Method loads names for given entity to ObjectManager
     *
     * @param ObjectManager $manager
     * @param string $className
     * @param array $names
     * @example [
     *
     * ]
     */
    private function loadToManager(
        ObjectManager $manager,
        string $className,
        array $names
    )
    {
        foreach ($names as $name) {
            $object = (new $className)->setName($name);
            $manager->persist($object);
            $this->addReference($name, $object);
        }
    }
}