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
        $lastposts = $postRepository->findLastPosts();
        //dd($posts);
        $oldposts = $postRepository->findOldPosts(10);
        return $this->render('post/posts.html.twig', [
            'post' => [
                'title' => 'La liste des articles',
                'content' => 'Contenu par défaut',
            ],
            'bg_image' => 'home-bg.jpg',
            'lastposts' => $lastposts,
            'oldposts' => $oldposts,
        ]);
    }

    /**
     * ---Route("/post/{id}", name="post_view", methods={"GET"}, requirements={"id"="\d+"})
     * @Route("/post/{slug}", name="post_view", methods={"GET"})
     */
    public function view(Post $post, PostRepository $postRepository): Response
    {
        //dd($post);
        //var_dump($id);

        $oldposts = $postRepository->findOldPosts(10);

        return $this->render('post/post.html.twig', [
            'post' =>  $post,
            'oldposts' =>  $oldposts,
            'bg_image' => $post->getImage(),
            //'controller_name' => 'Post ID ' . $id . '',
            //'id' => $id
        ]);
    }
}
