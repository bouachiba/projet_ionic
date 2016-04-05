<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ArticleController
 * @package AppBundle\Controller
 *
 * @Route("article")
 */

class ArticleController extends AbstractFrontController
{
    /**
     * @Route("/", name="article_list")
     * @return Response
     */
    public function indexAction()
    {
        $params=$this->getAsideData();
        return $this->render('article/index.html.twig',$params);
    }

    /**
     * @Route("/{id}", name="article_details")
     * @return Response
     */
    public function detailsAction()
    {
        $params=$this->getAsideData();
        return $this->render('article/details.html.twig',$params);
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
