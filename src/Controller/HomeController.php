<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Form\PostFormType;
use App\Security\EmailVerifier;
use App\Form\RegistrationFormType;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;


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


}
