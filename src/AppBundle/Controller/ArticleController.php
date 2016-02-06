<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Form\CommentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Controller\AbstractFrontEndController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ArticleController
 * @package AppBundle\Controller
 *
 * @Route("article")
 */

class ArticleController extends AbstractFrontEndController
{
    /**
     * @Route("/", name="article_list")
     * @return Response
     */
    public function indexAction()
    {
        $articleRepository= $this->getDoctrine()->getRepository('AppBundle:Article');

        $params = $this->getAsideData();
        $params['allArticles'] = $articleRepository->findAll();

        return $this->render('article/index.html.twig', $params);
    }

    /**
     * @Route("/{id}", name="article_details")
     * @return Response
     */
    public function detailsAction(Request $request, $id)
    {
        //Récupération de l'article
        $articleRepository = $this->getDoctrine()->getRepository('AppBundle:Article');
        $article = $articleRepository->find($id);

        // Instanciation de Comment
        // et initialisation de l'association avec l'article
        // de façon à insérer un commentaire sur un article particulier
        $comment = new Comment();
        $comment->setArticle($article);

        //Création du formulaire
        $form = $this->createForm(CommentType::class,
            $comment,
            array(
                'action' => $this->generateUrl('article_details', array('id' => $id))
            )
        );

        // Hydratation du formulaire avec la requête
        $form->handleRequest($request);

        // Traitement du formulaire
        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            //Redirection pour Réinitialiser le formulaire
            return $this->redirectToRoute('article_details', array('id' => $id));

        }

        //Paramètres passés à la vue
        $params = $this->getAsideData();
        $params['article'] = $article;
        $params['commentForm'] = $form->createView();

        return $this->render('article/details.html.twig', $params);
    }

    /**
     * @Route("/by-tag/{tag}", name="article_by_tag")
     * @param $tag
     * @return Response
     */
    public function showByTagAction($tag){
        $articleRepository = $this->getDoctrine()->getRepository('AppBundle:Article');

        $params = $this->getAsideData();
        $params['allArticles'] = $articleRepository->getArticleByTag($tag);
        $params['queryTitle'] = "par tag : $tag";

        return $this->render('article/index.html.twig', $params);
    }

    /**
     * @Route("/by-year/{year}", name="article_by_year",
     * requirements={"year": "\d{4}"}
     * )
     * @param $year
     * @return Response
     */
    public function showByYearAction($year){
        $articleRepository = $this->getDoctrine()->getRepository('AppBundle:Article');

        $params = $this->getAsideData();
        $params['allArticles'] = $articleRepository->getArticleByYear($year);
        $params['queryTitle'] = "par année : $year";

        return $this->render('article/index.html.twig', $params);
    }

    /**
     * @Route("/by-author/{id}", name="article_by_author",
     * requirements={"id": "\d+"}
     * )
     * @param $id
     * @return Response
     */
    public function showByAuyhorAction($id){
        $articleRepository = $this->getDoctrine()->getRepository('AppBundle:Article');
        $authorRepository = $this->getDoctrine()->getRepository('AppBundle:Author');

        $author = $authorRepository->find($id);

        $params = $this->getAsideData();
        $params['allArticles'] = $articleRepository->getArticleByAuthor($id);
        $params['queryTitle'] = "par auteur : ".$author->getFullName();

        return $this->render('article/index.html.twig', $params);
    }

    /**
     * @Route("/new", name="article_new")
     * @Route("/edit/{id}", name="article_edit")
     * @param int $id
     * @return Response
     */
    public function addEditAction($id = null)
    {
        return $this->render('article/form.html.twig');
    }
}
