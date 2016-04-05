<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Services\FakeDataProvider;
class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @return Response
     */
    public function indexAction(){
        
        $dataProvider=$this->getDataProvider();
        $articles=$dataProvider->getAllArticles();
        $tags=$dataProvider->getTags();
        $params=array(
            
            
            'articles'=>$articles,
            'tags'=>$tags
            
        );
        

        return $this->render(
            'default/index.html.twig',
            $params
        );
    }
    
    /**
     * 
     * @return FakeDataProvider
     */
    private function getDataProvider() {
        return $this->get('data_provider');
        
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
}
