<?php

namespace App\Repository;

use App\Entity\Classroom;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;


/**
 * @method Classroom find($id, $lockMode = null, $lockVersion = null)
 */
class ClassroomRepository extends ServiceEntityRepository
{
    private $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
        parent::__construct($managerRegistry, Classroom::class);
    }

    public function findById(int $id): ?Classroom
    {
        return $this->find($id);
    }

    public function save(Classroom $classroom): void
    {
        $entityManager = $this->managerRegistry->getManager();
        $entityManager->persist($classroom);
        $entityManager->flush();
    }

    public function delete(Classroom $classroom): void
    {
        $entityManager = $this->managerRegistry->getManager();
        $entityManager->remove($classroom);
        $entityManager->flush();
    }
}
