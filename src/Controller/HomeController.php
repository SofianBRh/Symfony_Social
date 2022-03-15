<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;
use App\Repository\PostRepository;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(PostRepository $post_repo): Response
    {
        $posts =$post_repo->findBy([],['createdAt' => 'desc']);
        return $this->render('home/index.html.twig', [
            'posts' => $posts
        ]);
    }
}
