<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Author;
use AppBundle\Entity\Article;
use AppBundle\Form\ArticleType;
use AppBundle\Form\AuthorType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class AuteurController
 * @package AppBundle\Controller
 *
 * @Route("author")
 */
class AuthorController extends Controller
{
    /**
     * @Route("/", name="author_home")
     * @return Response
     */
    public function indexAction()
    {
        $articleRepository = $this->getDoctrine()->getRepository('AppBundle:Article');
        $articles = $articleRepository->getArticleByAuthor($this->getUser()->getId());

        return $this->render('author/index.html.twig',
            array('articles' => $articles)
        );
    }

    /**
     * @Route("/edit/{id}", name="author_edit")
     * @param int $id
     * @return Response
     */
    public function editAction($id = null)
    {
        return $this->render('author/form.html.twig');
    }

    /**
     * @Route("/article/new", name="article_new")
     * @Route("/article/edit/{id}", name="article_edit")
     *
     * @Security("has_role('ROLE_AUTHOR')")
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function addEditAction(Request $request, $id = null)
    {
        if($id == null){
            $article = new Article();
            // L'auteur de l'article est l'utilisateur identifié
            $article->setAuthor($this->getUser());

            $postUrl = $this->generateUrl('article_new');
        } else {
            $articleRepository = $this->getDoctrine()->getRepository('AppBundle:Article');
            $article = $articleRepository->find($id);
            $postUrl = $this->generateUrl('article_edit', array('id' => $id));
        }

        $form = $this->createForm(ArticleType::class, $article,
            array('action' => $postUrl)
        );

        $form->handleRequest($request);

        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            //Message Flash de confirmation
            $this->addFlash('info','Votre article est enregistré dans la base de données');

            return $this->redirectToRoute('author_home');
        }

        return $this->render('article/form.html.twig',
            array('articleForm' => $form->createView())
        );
    }
}
