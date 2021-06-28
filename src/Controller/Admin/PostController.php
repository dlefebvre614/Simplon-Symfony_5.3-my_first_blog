<?php

namespace App\Controller\Admin;

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
     * @Route("/admin/post", name="admin_post_index")
     */
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('admin/post/index.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/post/activate/{id}", name="admin_post_activate", requirements={"id"="\d+"})
     */
    public function activatePost(Post $post): Response
    {
        //return $this->render('admin/post/index.html.twig', [
        //    'posts' => $postRepository->findAll(),
        //]);
        //dd($post);
        $post->setActive( ($post->getActive()) ? false : true);
        $em = $this->getDoctrine()->getManager();
        $em->persist($post);
        $em->flush();
        return new Response("true");
    }

    /**
     * @Route("/admin/post/add", name="admin_post_add")
     */
    public function addAdminPost(Request $request): Response
    {
        $post = new Post();
        //dd($post);
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //dd($form);
            //dd($post);
            $post->setUser($this->getUser());
            $post->setActive(false);
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            $this->addFlash('success', 'Votre article a été ajoutée avec succès !');
            return $this->redirectToRoute('admin_post_index');
        }

        return $this->render('admin/post/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/post/update/{id}", name="admin_post_update", requirements={"id"="\d+"})
     */
    public function updatePost(Post $post, Request $request): Response
    {
        // $post = new Post();
        //dd($post);
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //dd($form);
            //dd($post);
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            $this->addFlash('success', 'Votre post a été mise à jour avec succès !');
            return $this->redirectToRoute('admin_post_index');
        }

        return $this->render('admin/post/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/admin/post/delete/{id}", name="admin_post_delete")
     */
    public function delete(Post $post): Response
    {
        $em = $this->getDoctrine()->getManager();
        //$em->remove($post);
        //$em->flush();
        $this->addFlash('success', 'Article supprimé !');
        return $this->redirectToRoute('admin_post_index');
    }
}
