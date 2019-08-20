<?php

namespace App\Controller\Rest;

use App\Entity\Classroom;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ClassroomController extends AbstractFOSRestController
{
    /**
     * @FOS\RestBundle\Controller\Annotations\Post("/classrooms")
     *
     * @param Request $request
     *
     * @return View
     */
    public function postArticle(Request $request): View
    {
        $classroom = new Classroom();
        $classroom->setName($request->get('name'));
        $this->classroomRepository->save($classroom);

        return View::create($classroom, Response::HTTP_CREATED);
    }
}
