<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HTTPFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;


class PostController extends AbstractController
{
    #[Route('/post', name: 'app_post')]
    public function index(): Response
    {
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }

    /**
     * @Route("/product", name="create_product")
     */

    public function createProduct(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

      
        $user = new User();
        $user->setEmail('sososetEmail@gmail.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword('kekeke');
        $user->setFirstname('jean');
        $user->setLastname('jeans');
        $user->setUsername('keke');
        $user->setIsVerified(1);


        $product = new Post();
        $product->setUser($user);
        $product->setTitle('ProductKeyboard');
        $product->setContent('Ergonomic and stylish!');
        $product->setStatus('salut');
        $product->setCreatedAt (new \DateTimeImmutable('2010-02-03 04:05:06 America/New_York'));

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($user);
        $entityManager->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$product->getId());
    }
}
