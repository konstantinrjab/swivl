<?php

namespace App\Controller\Rest;

use App\Entity\Classroom;
use App\Repository\ClassroomRepository;
use App\Service\ClassroomValidationService;
use Doctrine\ORM\EntityNotFoundException;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

class ClassroomController extends AbstractFOSRestController
{
    private const CLASSROOM_NOT_FOUND = 'Classroom not found: ';

    /** @var ClassroomValidationService $validationService */
    private $validationService;

    /** @var ClassroomRepository $classroomRepository */
    private $classroomRepository;

    public function __construct(
        ClassroomRepository $classroomRepository,
        ClassroomValidationService $validationService
    )
    {
        $this->validationService = $validationService;
        $this->classroomRepository = $classroomRepository;
    }

    /**
     * @Rest\Post("/classrooms")
     *
     * @param Request $request
     *
     * @return View
     */
    public function addClassroom(Request $request): View
    {
        $violations = $this->validationService->onCreate($request);

        if ($violations) {
            return View::create($violations, Response::HTTP_BAD_REQUEST);
        }

        $classroom = $this->classroomRepository->add($request->get('name'));

        return View::create($classroom, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Get("/classrooms/{classroomId}")
     *
     * @param int $classroomId
     *
     * @return View
     *
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function getClassroom(int $classroomId): View
    {
        $classroom = $this->getClassroomByIdOrDie($classroomId);

        return View::create($classroom, Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/classrooms")
     */
    public function getClassrooms(): View
    {
        $classrooms = $this->classroomRepository->findAll();

        return View::create($classrooms, Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/classrooms/{classroomId}")
     *
     * @param int $classroomId
     * @param Request $request
     *
     * @return View
     *
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function updateClassroom(int $classroomId, Request $request): View
    {
        $classroom = $this->getClassroomByIdOrDie($classroomId);
        $violations = $this->validationService->onUpdate($request);

        if ($violations) {
            return View::create($violations, Response::HTTP_BAD_REQUEST);
        }

        $this->classroomRepository->updateName($classroom, $request->get('name'));

        return View::create($classroom, Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/classrooms/{classroomId}/activate")
     *
     * @param int $classroomId
     * @param Request $request
     *
     * @return View
     *
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function activateClassroom(int $classroomId, Request $request): View
    {
        $classroom = $this->getClassroomByIdOrDie($classroomId);
        $violations = $this->validationService->onActivate($request);
        if ($violations) {
            return View::create($violations, Response::HTTP_BAD_REQUEST);
        }

        $this->classroomRepository->activate($classroom, $request->request->getBoolean('active'));

        return View::create($classroom, Response::HTTP_OK);
    }

    /**
     * @Rest\Delete("/classrooms/{classroomId}")
     *
     * @param int $classroomId
     * @param Request $request
     *
     * @return View
     *
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function deleteClassroom(int $classroomId, Request $request): View
    {
        $classroom = $this->getClassroomByIdOrDie($classroomId);

        $this->classroomRepository->delete($classroom);

        return View::create(null, Response::HTTP_NO_CONTENT);
    }

    private function getClassroomByIdOrDie(int $classroomId): Classroom
    {
        $classroom = $this->classroomRepository->findById($classroomId);
        if (!$classroom) {
            throw new EntityNotFoundException(self::CLASSROOM_NOT_FOUND.$classroomId);
        }

        return $classroom;
    }
}
