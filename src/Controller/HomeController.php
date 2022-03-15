<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Form\PostFormType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(PostRepository $post_repo, Request $request, EntityManagerInterface $em): Response
    {
        # Souscription de l'utilisateur
        /** @var User $user */
        $user = $this->getUser();
        
        $post = new post();

        $form = $this->createForm(PostFormType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $post->setUser($user);
            $em->persist($post);
            $em->flush();
        }

        $posts =$post_repo->findBy(['status' => 'published'],['createdAt' => 'desc']);
        return $this->render('home/index.html.twig', [
            'posts' => $posts,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/home/{id}/delete", name="app_delete")
     * @param Post $post
     * @return RedirectResponse
     */

    #[Route('/home', name: 'app_delete', methods: ['GET', 'POST'])]
    public function delete(Post $post, EntityManagerInterface $em):RedirectResponse
    {
        $em->remove($post);
        $em->flush();

        return $this->redirectToRoute(route : "app_home");
    }

    #[Route("/home/{id}/edit", name: 'app_edit', methods: ['GET', 'POST'])]
    public function edit(Post $post, Request $request, EntityManagerInterface $em) : Response
    {
        $form = $this->createForm(PostFormType::class, $post);
        $form->handleRequest($request);
        return $this->render('post/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
