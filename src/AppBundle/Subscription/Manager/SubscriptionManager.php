<?php
namespace AppBundle\Subscription\Manager;


use Doctrine\ORM\EntityManager;
use AppBundle\Repository\SubscriptionRepository;

class SubscriptionManager
{
     /**
     * @var EntityManager
     */
    protected $em;

     /**
     * @var SubscriptionRepository
     */
    protected $SubscriptionRepository;


    public function __construct(EntityManager $em,SubscriptionRepository $SubscriptionRepository)
    {
        $this->em = $em;
        $this->SubscriptionRepository = $SubscriptionRepository;


    }   
   
    public function find($code)
    {
        return $this->SubscriptionRepository->findOneByContact($code);
    }
    public function delete($id)
    {
        return $this->SubscriptionRepository->remove($id);
    }


    


}