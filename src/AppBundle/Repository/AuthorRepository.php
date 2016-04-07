<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;



/**
 * Description of AuthorRepository
 *
 * @author moustakil
 */
class AuthorRepository  extends EntityRepository{
     
   public function getAuteurList(){
        $qb= $this->createQueryBuilder('a')
                 ->select("a.id,concat_ws(' ',a.firstName,upper(a.name)) as fullName,COUNT(ar.id) as numberOfArticles")
                 ->join('a.articles', 'ar')
                 ->groupBy('a.id') ;
         return $qb->getQuery();
        
    }
}
