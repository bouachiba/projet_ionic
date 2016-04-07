<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Services\FakeDataProvider;

abstract class AbstractFrontEndController extends Controller
{
    /**
     * @return FakeDataProvider
     */
    protected function getDataProvider(){
        return $this->get('data_provider');
    }

    protected function getAsideData(){
        $dataProvider = $this->getDataProvider();
        
        $tagRepository=$this->getDoctrine()->getRepository('AppBundle:Tag');
          $tags = $tagRepository->getTagList()->getArrayResult();
        
        $articleRepository= $this->getDoctrine()->getRepository('AppBundle:Article');
        $archives = $articleRepository->getArchive();
        
         $AuthorRepository=$this->getDoctrine()->getRepository('AppBundle:Author');
        $authors = $AuthorRepository->getAuteurList()->getArrayResult();
        
        $lastComments = $dataProvider->getAllComments();
        $popularArticles = $dataProvider->getAllArticles();

        return array(
            'tags'    => $tags,
            'archives' => $archives,
            'authors' => $authors,
            'popularArticles'=> $popularArticles,
            'lastComments'=> $lastComments
        );
    }
}
