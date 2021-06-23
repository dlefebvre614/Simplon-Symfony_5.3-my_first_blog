<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function home(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findOldPosts(10);
        dd($posts);
        return $this->render('post/posts.html.twig', [
            'post' => [

                'title' => 'La liste des articles',
                'content' => 'Contenu par défaut',
            ],
            'bg_image' => 'home-bg.jpg',
            'posts' => $posts,
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
