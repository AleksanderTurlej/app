<?php

namespace App\Service;

use App\Entity\AbstractEntity;
use Doctrine\ORM\EntityManagerInterface;

class PersisterService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(AbstractEntity $entity): void
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function remove(AbstractEntity $entity): void
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }
}
