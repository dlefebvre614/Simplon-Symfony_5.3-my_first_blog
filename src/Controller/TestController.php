<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index(): Response
    {
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }

    /**
     * @Route("/test/{id}", name="test_id", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function test_id($id): Response
    {
        //dd($id);
        //var_dump($id);
        return $this->render('test/index.html.twig', [
            'controller_name' => 'Test ID ' . $id . '',
            'id' => $id
        ]);
    }
}
