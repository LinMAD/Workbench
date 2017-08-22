<?php

namespace CarBundle\Service;

use CarBundle\Entity\Car;
use Doctrine\ORM\EntityManager;

class DataChecker
{
    /**
     * @var bool
     */
    protected $requireImagesToPromoteCar;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * DataChecker constructor
     *
     * @param EntityManager $entityManager
     * @param bool          $requireImagesToPromoteCar
     *
     */
    public function __construct(EntityManager $entityManager, bool $requireImagesToPromoteCar)
    {
        $this->entityManager = $entityManager;
        $this->requireImagesToPromoteCar = $requireImagesToPromoteCar;
    }

    /**
     * Verify car of promotion and store value
     *
     * @param Car $car
     *
     * @return bool
     * @throws \Doctrine\ORM\TransactionRequiredException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     */
    public function checkCar(Car $car): bool
    {
        $promote = true;

        if ($this->requireImagesToPromoteCar) {
            $promote = false;
        }

        $car->setPromote($promote);
        
        $this->entityManager->persist($car);
        $this->entityManager->flush();

        return $promote;
    }

}