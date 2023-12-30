<?php declare(strict_types=1);

namespace App\Service;

use App\Interface\IIncrementalCounter;
use Doctrine\ORM\EntityManagerInterface;
use Throwable;

class IncrementalCounterService
{
    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(protected EntityManagerInterface $entityManager)
    {
    }

    /**
     * @param IIncrementalCounter $object
     * @return void
     */
    public function incrementCounter(IIncrementalCounter $object): void
    {
        $object->incrementCounter();

        try {
            $this->entityManager->persist($object);
            $this->entityManager->flush();
        } catch (Throwable) {
        }
    }
}
