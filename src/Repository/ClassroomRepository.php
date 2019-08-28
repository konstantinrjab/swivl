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

    public function add(string $name): Classroom
    {
        $classroom = new Classroom();
        $classroom->setName($name);
        $this->save($classroom);

        return $classroom;
    }

    public function updateName(Classroom $classroom, string $name): void
    {
        $classroom->setName($name);
        $this->save($classroom);
    }

    public function activate(Classroom $classroom, bool $active): void
    {
        $classroom->setActive($active);
        $this->save($classroom);
    }

    public function delete(Classroom $classroom): void
    {
        $entityManager = $this->managerRegistry->getManager();
        $entityManager->remove($classroom);
        $entityManager->flush();
    }

    private function save(Classroom $classroom): void
    {
        $entityManager = $this->managerRegistry->getManager();
        $entityManager->persist($classroom);
        $entityManager->flush();
    }
}
