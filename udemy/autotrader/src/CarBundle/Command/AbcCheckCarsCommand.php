<?php

namespace CarBundle\Command;

use CarBundle\Entity\Car;
use CarBundle\Service\DataChecker;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AbcCheckCarsCommand extends Command
{
    /**
     * @var DataChecker
     */
    private $dataChecker;

    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(
        DataChecker $dataChecker,
        EntityManager $entityManager
    ){
        parent::__construct();
        $this->dataChecker = $dataChecker;
        $this->entityManager = $entityManager;
    }

    /**
     * Configuration of command check car
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    protected function configure(): void
    {
        $this->setName('abc:check-cars')
            ->setDescription('Check all cars')
            ->addArgument('format', InputArgument::OPTIONAL, 'Progress format')
            ->addOption('option', null, InputOption::VALUE_NONE, 'Option description');
    }

    /**
     * Execute command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     *
     * @throws \LogicException
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     * @throws \Doctrine\ORM\ORMException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Get repository's
        $carRepository = $this->entityManager->getRepository(Car::class);

        // Get all cars
        $cars = $carRepository->findAll();

        // Setup progress bar
        $bar = new ProgressBar($output, count($cars));
        $bar->setFormat($input->getArgument('format'));
        $bar->start();

        // Execute command of validation of cars
        /** @var Car $car */
        foreach ($cars as $car) {
            $this->dataChecker->checkCar($car);
            $bar->advance();
        }

        $bar->finish();
    }
}
