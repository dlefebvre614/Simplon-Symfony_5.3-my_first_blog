<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Form\PostType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_home")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

        /**
     * @Route("/admin/test", name="admin_test")
     */
    public function test(): Response
    {
        return $this->render('admin/test.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/post/add", name="post_add")
     */
    public function addPost(Request $request): Response
    {
        $post = new Post();
        //dd($category);
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post->setUser($this->getUser());
            $post->setActive(true);
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            // @TODO Change the redirect on success and handle or remove the flash message in your templates
            $this->addFlash('success', 'Votre post a été ajoutée avec succès !');
            return $this->redirectToRoute('home');
        }

        return $this->render('admin/post/add.html.twig', [
            'form' => $form->createView(),
            'bg_image' => 'home-bg.jpg',
        ]);
    }
}
