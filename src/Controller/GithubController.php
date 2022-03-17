<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GithubController extends AbstractController
{
    #[Route('/connect/github', name: 'connect_github_start', methods: ['GET', 'POST'])]
    public function connectGithubAction(ClientRegistry $clientRegistry)
    {
        return $clientRegistry
            // ID used in config/packages/knpu_oauth2_client.yaml
            ->getClient('github_main')
            // Request access to scopes
            // https://www.google.com/webhp?hl=fr&sa=X&ved=0ahUKEwiHifqNqs32AhVggf0HHZmAAAUQPAgI
            ->redirect([
                'user:email'
            ])
        ;
    }

    #[Route('/connect/github/check', name: 'connect_github_check', methods: ['GET', 'POST'])]
    public function connectGithubCheckAction(Request $request, ClientRegistry $clientRegistry)
    {
        return $this->redirectToRoute('app_home');
    }
}

