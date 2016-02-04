<?php

namespace AppBundle\Controller;

use AppBundle\Services\FakeDataProvider;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @return Response
     */
    public function indexAction()
    {
        $dataProvider = $this->getDataProvider();
        $tags = $dataProvider->getTags();
        $archives = $dataProvider->getArchive();
        $authors = $dataProvider->getAllAuthors();
        $lastComments = $dataProvider->getAllComments();
        $popularArticles = $dataProvider->getAllArticles();

        $lastArticles = $dataProvider->getAllArticles();

        return $this->render(
            'default/index.html.twig',
            array(  'tags'    => $tags,
                    'archives' => $archives,
                    'authors' => $authors,
                    'lastArticles'=> $lastArticles,
                    'popularArticles'=> $popularArticles,
                    'lastComments'=> $lastComments
            )
        );
    }

    /**
     * @Route("/about", name="about_page")
     * @return Response
     */
    public function aboutAction(){
        return $this->render(
            'static/about.html.twig',
            array()
        );
    }

    /**
     * @Route("/test")
     * @return Response
     */
    public function testAction(){
        $dataProvider = $this->get('data_provider');
        $data = $dataProvider->getAllArticles();
        return $this->render('default/test.html.twig', array('data' => $data));
    }

    /**
     * @return FakeDataProvider
     */
    private function getDataProvider(){
        return $this->get('data_provider');
    }
}
