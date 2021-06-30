<?php

// namespace du controleur
namespace App\Controller\Admin;

// mamespaces utilisés
    // défini où la class doit trouver les attributs de l'entité post
use App\Entity\Post;
    // défini où la class doit trouver les attributs du formulaire post
use App\Form\PostType;
    // défini où la class doit trouver les attributs pour faire la requete SQL
use App\Repository\PostRepository;
    // défini où la class doit trouver les attributs pour faire la page html
use Symfony\Component\HttpFoundation\Request;
    // défini où la class doit trouver les attributs pour faire la page html    
use Symfony\Component\HttpFoundation\Response;
    // défini où la class doit trouver les attributs pour l'annotation des routes 
use Symfony\Component\Routing\Annotation\Route;
    // défini où la class doit trouver les attributs de gestion des routes
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// class PostControleur chargé de gérer les routes et le code hors services
class PostController extends AbstractController
{
        // route pour voir la liste des articles
    /**
     * @Route("/admin/post", name="admin_post_index")
     */
    // methode utilisant l'intanciation de la classe postRepository
    public function index(PostRepository $postRepository): Response
    {
            // rendu vers la vue avec recherche des données entités.
        return $this->render('admin/post/index.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);
    }

        // route qui permet à la vue liste de d'article vue admin de changer l'activation de l'article en AJAX
    /**
     * @Route("/admin/post/activate/{id}", name="admin_post_activate", requirements={"id"="\d+"})
     */
    public function activatePost(Post $post): Response
    {
        //return $this->render('admin/post/index.html.twig', [
        //    'posts' => $postRepository->findAll(),
        //]);
        //dd($post);
        // méthode switch vrai / faut pour le bouton ajax
        $post->setActive( ($post->getActive()) ? false : true);
        // manager recupération données pour constituer la resquete SQL
        $em = $this->getDoctrine()->getManager();
        // rend persistant les données
        $em->persist($post);
        // les commit dans la base de données
        $em->flush();
        // retourne vrai
        return new Response("true");
    }

        // route qui permet d'ajouter un article
    /**
     * @Route("/admin/post/add", name="admin_post_add")
     */
    // methode
    public function addAdminPost(Request $request): Response
    {
            // ajout d'un nouvel article
        $post = new Post();
        //dd($post);
            // instanciation de la classe des articles
        $form = $this->createForm(PostType::class, $post);
            // appel du formulaire avec les attribut de la class
        $form->handleRequest($request);

            // test si le formulaire est soumit et valide back-end
        if ($form->isSubmitted() && $form->isValid()) {
            //dd($form);
            //dd($post);
                // utilisation du set pour récupérer les attribut et set pour les mettre à jour
            $post->setUser($this->getUser());
                // met l'attribut active à faut (non actif)
            $post->setActive(false);
                // met à jour les entités
            $em = $this->getDoctrine()->getManager();
                // rend persistant les entités
            $em->persist($post);
                // commit dans la base de données
            $em->flush();
                // positionne un message flash pour la prochaine vue
            $this->addFlash('success', 'Votre article a été ajoutée avec succès !');
                // renvoi vers la routs liste admin des articles
            return $this->redirectToRoute('admin_post_index');
        }
            // rendu et création de la vue avec le formulaire
        return $this->render('admin/post/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

        // route qui permet de mettre à jour un article
    /**
     * @Route("/admin/post/update/{id}", name="admin_post_update", requirements={"id"="\d+"})
     */
    //Méthode qui recupère l'instanciation ds classes post et Request
    public function updatePost(Post $post, Request $request): Response
    {
        // $post = new Post();
        //dd($post);
            // creation formulaire avec les données de l'intanciation de la classe PostType
        $form = $this->createForm(PostType::class, $post);
            // constitue le formulaire à partir des entité
        $form->handleRequest($request);

            // vérifie si soumit et validé en back-end
        if ($form->isSubmitted() && $form->isValid()) {
            //dd($form);
            //dd($post);
            // appel du manager de doctrine
            $em = $this->getDoctrine()->getManager();
            // rend persistant les entaité
            $em->persist($post);
            // commit dans la basse
            $em->flush();
            // prépare un message flach pour la vue suivante
            $this->addFlash('success', 'Votre post a été mise à jour avec succès !');
            // va vers la route suivante
            return $this->redirectToRoute('admin_post_index');
        }

            // cré la vue avec le formulaire
        return $this->render('admin/post/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

        // route qui permet de supprimer un article ($em commenté)
    /**
     * @Route("/admin/post/delete/{id}", name="admin_post_delete")
     */
    // Méthode utilisant une intanciation de la class post
    public function delete(Post $post): Response
    {
            // appel de manager doctrine
        $em = $this->getDoctrine()->getManager();
            // préparation de la commande QL de supprssion de l'article
        //$em->remove($post);
            // commit : suppression de l'article dans la base
        //$em->flush();
            // préparation d'un message flash pour la prochaine vue
        $this->addFlash('success', 'Article supprimé !');
            // indique la route suivante à suivre pour afficher la vue suivante
        return $this->redirectToRoute('admin_post_index');
    }
}
