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
    public function index(PostRepository $post_repo): Response
    {
        # Souscription de l'utilisateur
        /** @var User $user */
        $user = $this->getUser();
        
        $postez = new post();

        $form = $this->createForm(PostFormType::class, $postez);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $now = new \DateTimeImmutable;
       
            $postez->setUser($user);
            $postez->setStatus("en cours");
            $postez->setCreatedAt ($now);
            $em->persist($postez);

            $em->flush();
        }

        $posts =$post_repo->findBy([],['createdAt' => 'desc']);
        return $this->render('home/index.html.twig', [
            'posts' => $posts,
            'form' => $form->createView()
        ]);
    }


}
