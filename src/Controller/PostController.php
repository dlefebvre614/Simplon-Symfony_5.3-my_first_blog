<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/post/{slug}", name="post_view", methods={"GET"}, priority=0)
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


    /**
     * @Route("/post/add", name="post_add", priority=1)
     */
    public function addPost(Request $request): Response
    {
        $post = new Post();
        //dd($post);
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //dd($form);
            //dd($category);
            $post->setUser($this->getUser());
            $post->setActive(false);

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            $this->addFlash('success', 'Votre article a été ajoutée avec succès !');
            return $this->redirectToRoute('home');
        }

        return $this->render('post/add.html.twig', [
            'form' => $form->createView(),
            'bg_image' => 'contact-bg.jpg',
        ]);
    }
}
