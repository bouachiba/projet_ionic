<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Author;

//namespace AppBundle\Controller;

/**
 * Description of playgroundController
 *@Route("playground")
 * @author moustakil
 */
class playgroundController extends Controller {
    /**
     * @Route("/",name="playground_home")
     */
    public function  indexAction(){
        $em=$this->getDoctrine()->getManager();
        $repositoryAuteur=$this->getDoctrine()->getRepository('AppBundle:Author');
        $auteur=$repositoryAuteur->findOneBy(array(
            'email'=>'karimmoust@yahoo.fr'));
        if ($auteur==null){
        //nouvel auteur
        /**
         * @var Author
         */
        $auteur=new Author;
        $auteur->setName('abdel')
                ->setEmail('karimmoust@yahoo.fr')
                ->setPassword('1234');      
        var_dump($auteur);
        $em->persist($auteur);
        $em->flush();
        }
        var_dump($auteur);
        return new response;
        
    }
    /**
     * @Route("/delete-all")
     * @return Response
     */
   public function deleteAll(){
       //liste de toutes les entités
       $repository = $this->getDoctrine()->getRepository('AppBundle:Author');
       
       $listeAuteur = $repository->findAll();
       
       $em = $this->getDoctrine()->getManager();
       //b
       foreach($listeAuteur as $auteur){
          
           $em->remove($auteur);
           
           
       } 
       $em->flush();
       return $this->redirectToRoute('playground_home');
   }
}
