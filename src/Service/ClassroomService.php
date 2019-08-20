<?php

namespace App\Service;

use App\Entity\Classroom;
use App\Repository\ClassroomRepository;
use Doctrine\ORM\EntityNotFoundException;

class ClassroomService
{
    private $classroomRepository;

    public function __construct(ClassroomRepository $classroomRepository)
    {
        $this->classroomRepository = $classroomRepository;
    }

    public function getClassroom(int $classroomId): ?Classroom
    {
        $classroom = $this->classroomRepository->findById($classroomId);
        if (!$classroom) {
            throw new EntityNotFoundException('Classroom with id '.$classroomId.' not found');
        }

        return $classroom;
    }

    public function getAllClassrooms(): array
    {
        return $this->classroomRepository->findAll();
    }

    public function addClassroom(string $name): Classroom
    {
        $classroom = new Classroom();
        $classroom->setName($name);
        $this->classroomRepository->save($classroom);

        return $classroom;
    }

    public function updateClassroom(int $classroomId, string $name): ?Classroom
    {
        $classroom = $this->classroomRepository->findById($classroomId);
        if (!$classroom) {
            throw new EntityNotFoundException('Classroom with id '.$classroomId.' not found');
        }
        $classroom->setName($name);
        $this->classroomRepository->save($classroom);

        return $classroom;
    }

    public function deleteClassroom(int $classroomId): void
    {
        $classroom = $this->classroomRepository->findById($classroomId);
        if ($classroom) {
            $this->classroomRepository->delete($classroom);
        }
    }
}