<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findAll();
        //dd($posts);
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
     * ---Route("/post/{id}", name="post_view", methods={"GET"}, requirements={"id"="\d+"})
     * @Route("/post/{slug}", name="post_view", methods={"GET"})
     */
    public function view(Post $post): Response
    {
        //dd($post);
        //var_dump($id);
        return $this->render('post/post.html.twig', [
            'post' =>  $post,
            'bg_image' => $post->getImage(),
            //'controller_name' => 'Post ID ' . $id . '',
            //'id' => $id
        ]);
    }
}
