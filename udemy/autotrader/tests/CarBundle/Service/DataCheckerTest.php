<?php

namespace CarBundle\Service;

use Doctrine\ORM\EntityManager;
use CarBundle\Entity\Car;
use PHPUnit\Framework\TestCase;

class DataCheckerTest extends TestCase
{
    /** @var EntityManager|\PHPUnit_Framework_MockObject_MockObject */
    protected $entityManager;

    public function setUp()
    {
        $this->entityManager = $this->getMockBuilder(EntityManager::class)->disableOriginalConstructor()->getMock();
    }

    public function testCheckCarWithRequiredPhotosWillReturnFalse()
    {
        $subject        = new DataChecker($this->entityManager, true);
        $expectedResult = false;

        $car    = $this->getMockBuilder(Car::class)->disableOriginalConstructor()->getMock();
        $car->expects($this->once())
            ->method('setPromote')
            ->with($expectedResult);

        $this->entityManager->expects($this->once())
            ->method('persist')
            ->with($car);
        $this->entityManager->expects($this->once())
            ->method('flush');

        $result = $subject->checkCar($car);
        $this->assertEquals($expectedResult, $result);
    }


}