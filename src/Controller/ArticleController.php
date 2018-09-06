<?php
/**
 * Created by PhpStorm.
 * User: qaltamore
 * Date: 03/09/18
 * Time: 22:51
 */

namespace App\Controller;


use App\Entity\Article;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use  Symfony\Component\Routing\Annotation\Route;

class ArticleController extends Controller
{
    /**
     * @Route("/article/create", name="create_article")
     * @param Request $request
     * @param bool $isEdit
     * @param Article|null $articleId
     * @param LoggerInterface $logger
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request, LoggerInterface $logger, $isEdit = false, Article $articleId=null)
    {

        $article = null;
        $form = null;
        $id = 0;
        if(!$isEdit){
            $article = new Article();
            $form = $this->createFormBuilder($article)
                ->add('title')
                ->add('content',TextareaType::class)
                ->add('isPublished', CheckboxType::class,[
                    'required' => false,
                ])
                ->add('Valider', SubmitType::class,[
                    'attr' => ['class' => 'ui positive button'],
                ])
                ->getForm();
        } else {
            $id = $articleId->getId();
            $form = $this->createFormBuilder($articleId)
                ->add('title')
                ->add('content',TextareaType::class)
                ->add('isPublished', CheckboxType::class,[
                    'required' => false,
                ])
                ->add('Valider', SubmitType::class,[
                    'attr' => ['class' => 'ui positive button'],
                ])
                ->getForm();
        }
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if(!$isEdit) {
                if($article->isPublished()) {
                    $article->setDate(true);
                } else{
                    $article->setDate(false);
                }
                $em->persist($article);
            }else{
                if($articleId->isPublished()){
                    $articleId->setDate(true);
                } else{
                    $articleId->setDate(false);
                }

            }
            try{
                $em->flush();
                if(!$isEdit){
                    $logger->info(sprintf("Création d'aticle ===> %d ; %s",$article->getId(),$article->getTitle()));
                }
            }catch (Exception $e){
                if(!$isEdit) {
                    $logger->error(sprintf("Erreur lors de la création de %d ; %s",$article->getId(),$article->getTitle()));
                }
            }

            return $this->redirectToRoute('article_list');

        }
        return $this->render('article/article.html.twig', [
            'form' => $form->createView(),
            'isEdit' => $isEdit,
            'id' => $id,
        ]);
    }


    /**
     * @Route("/article/edit/{articleId}")
     *
     * @param Article $articleId
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function modifyAction(Article $articleId, Request $request)
    {
         return $this->forward('App\Controller\ArticleController::createAction', array(
            'request'  => $request,
            'articleId' => $articleId,
            'isEdit'=> true,
        ));

    }

    /**
     * @Route("/article/show/{articleId}")
     *
     * @param Article $articleId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Article $articleId)
    {
        return $this->render('article/showArticle.html.twig', compact('articleId'));
    }

    /**
     * @Route("/article/delete/{articleId}")
     *
     * @param Article $articleId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Article $articleId)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($articleId);
        $entityManager->flush();
        return $this->redirectToRoute('article_list');

    }
    /**
     * @Route("/article", name ="article_list")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        $articles = $this->getDoctrine()->getRepository(Article::class)->findBy(
            array(),
            array('id'=>'DESC'));

        return $this->render('article/listArticle.html.twig', compact('articles'));
    }

}