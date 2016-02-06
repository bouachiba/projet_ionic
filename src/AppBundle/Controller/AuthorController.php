<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Author;
use AppBundle\Form\AuthorType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
        return $this->render('author/index.html.twig');
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
}
