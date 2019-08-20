<?php

namespace App\Controller\Rest;

use App\Service\ClassroomService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

class ClassroomController extends AbstractFOSRestController
{
    /** @var ClassroomService $classroomService */
    private $classroomService;

    public function __construct(ClassroomService $classroomService)
    {
        $this->classroomService = $classroomService;
    }

    /**
     * @Rest\Post("/classrooms")
     *
     * @param Request $request
     *
     * @return View
     */
    public function postClassroom(Request $request): View
    {
        $classroom = $this->classroomService->addClassroom($request->get('name'));

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
        $classroom = $this->classroomService->getClassroom($classroomId);

        return View::create($classroom, Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/classrooms")
     */
    public function getClassrooms(): View
    {
        $classrooms = $this->classroomService->getAllClassrooms();

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
    public function putArticle(int $classroomId, Request $request): View
    {
        $classroom = $this->classroomService->updateClassroom(
            $classroomId,
            $request->get('name')
        );

        return View::create($classroom, Response::HTTP_OK);
    }
}
