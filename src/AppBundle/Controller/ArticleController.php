<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Controller\AbstractFrontEndController;
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
        $ArticleRepository = $this->getDoctrine()->getRepository('AppBundle:Article');

        $params = $this->getAsideData();
        $params['allArticles'] = $ArticleRepository->findAll();

        return $this->render('article/index.html.twig', $params);
    }

    /**
     * @Route("/{id}", name="article_details")
     * @return Response
     */
    public function detailsAction($id)
    {
        $ArticleRepository = $this->getDoctrine()->getRepository('AppBundle:Article');

        $params = $this->getAsideData();
        $params['article'] = $ArticleRepository->find($id);

        return $this->render('article/details.html.twig', $params);
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
