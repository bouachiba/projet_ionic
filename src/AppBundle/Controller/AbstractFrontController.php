<?php



namespace AppBundle\Controller;
use \Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Services\FakeDataProvider;
/**
 * Description of AbstractFrontController
 *
 * @author moustakil
 */
abstract class AbstractFrontController extends Controller {
  
     
    /**
     * 
     * @return FakeDataProvider
     */
    protected function getDataProvider() {
        return $this->get('data_provider');
        
    }
    protected function getAsideData(){
        $dataProvider=  $this->getDataProvider();
        return array(
            'tags'=>$dataProvider->getTags(),
            'archives'=>$dataProvider->getArchive()
            
        );
        
        
        
    }
    
    
}
