<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Author;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class PlaygroundController
 * @package AppBundle\Controller
 *
 * @Route("playground")
 */
class PlaygroundController extends Controller
{
    /**
     * @return Response
     * @Route("/author")
     */
    public function testAuthorAction()
    {
        $author = new Author();
        $author ->setFirstName('Marcel')
                ->setName('Duchamps')
                ->setEmail('mduchamps@gamil.com')
                ->setPassword(sha1('password'));

        $em = $this->getDoctrine()->getManager();

        $em->persist($author);

        $em->flush();

        $data = $author;
        return $this->render('playground/author-playground.html.twig', array('data' => $data));
    }
}
