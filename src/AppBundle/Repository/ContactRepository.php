<?php

namespace AppBundle\Repository;

/**
 * ContactRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ContactRepository extends \Doctrine\ORM\EntityRepository
{
    public function findContact($id)
    {
    	
     return $this->find($id); 
     
    }
}
