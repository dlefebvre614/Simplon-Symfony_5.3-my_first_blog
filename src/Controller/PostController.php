<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        return $this->render('post/posts.html.twig', [
            'post' => [
                'title' => 'La liste des articles',
                'content' => 'Contenu par défaut',
            ],
            'bg_image' => 'home-bg.jpg',
        ]);
    }

    /**
     * @Route("/post/{id}", name="post_view", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function view($id): Response
    {
        //dd($id);
        //var_dump($id);
        return $this->render('post/post.html.twig', [
            'post' => [
                'title' => 'Le titre de l\'article',
                'content' => 'Le contenu de notre article',
            ],
            'bg_image' => 'post-bg.jpg',
            //'controller_name' => 'Post ID ' . $id . '',
            //'id' => $id
        ]);
    }
}
