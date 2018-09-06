<?php

/*...*/

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use  Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
class HomeController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function homeAction()
    {
        $articleId = $this->getDoctrine()->getRepository(Article::class)->findBy(
            array('isPublished'=>1),
            array('id'=>'DESC')
        );

        return $this->render('home/home.html.twig', [
            'articleId' => $articleId[0]
        ]);
    }
}