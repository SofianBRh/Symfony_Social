<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DetailController extends AbstractController
{

   
    #[Route('/detail{id}', name: 'app_detail', methods: ['GET'])]
    public function index(Post $post): Response 
    {
        return $this->render('detail/index.html.twig', [
        "post"=>$post
        ]);
    }


//  public function show($slug, DetailRepository $detailRepository): Response{

// $detail = $detailRepository->findOneBy(['slug'=>$slug]);
// if(!$detail){

// throw $this->createNotFoundException('Aucun article retrouvé avec ce slug!');

// }

// return $this->render('detail/index.html.twig', [
//     'post'=> $detail
// ]);

//  }

}
 





