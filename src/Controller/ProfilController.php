<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Post;

class ProfilController extends AbstractController
{

    #[Route('/profil', name: 'app_profil', methods: ['GET'])]

    /**
     * @Route("/users", name="users")
     */
    public function index()
    {
        return $this->render('profil/index.html.twig');
    }
}
