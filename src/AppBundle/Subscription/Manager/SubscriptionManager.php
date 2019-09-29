<?php
namespace AppBundle\Subscription\Manager;


use Doctrine\ORM\EntityManager;
use AppBundle\Repository\SubscriptionRepository;
use AppBundle\Repository\ProductRepository;
use AppBundle\Repository\ContactRepository;
use AppBundle\Entity\Subscription;

class SubscriptionManager
{
    
    public function __construct(
        EntityManager $em,
        SubscriptionRepository $SubscriptionRepository,
        ProductRepository $ProductRepository,
        ContactRepository $ContactRepository
        )
    {
        $this->em = $em;
        $this->SubscriptionRepository = $SubscriptionRepository;
        $this->ProductRepository = $ProductRepository;
        $this->ContactRepository = $ContactRepository;
    }   
   
    public function find($code)
    {
        return $this->SubscriptionRepository->findOneByContact($code);
    }

    public function delete($id)
    {
        return $this->SubscriptionRepository->remove($id);
    }

    public function save($request)
    {
       $data = new Subscription;
	   $beginDate = new \DateTime($request->get('beginDate'));
	   $endDate = new \DateTime($request->get('endDate'));
	   $product = $this->ProductRepository->findProduct($request->get('product'));
	   $contact = $this->ContactRepository->findContact($request->get('contact'));
	
		 if(empty($product) || empty($contact))
		 {
		   return false; 
		 } 

		  $data->setBeginDate($beginDate);
		  $data->setEndDate($endDate);
		  $data->setContact($contact);
	      $data->setProduct($product);
          $this->SubscriptionRepository->save($data);

          return true;
		  
    }

    public function update($request,$id)
    {
        $beginDate = new \DateTime($request->get('beginDate'));
        $endDate = new \DateTime($request->get('endDate'));
        $product = $this->ProductRepository->find($request->get('product'));
        $contact =  $this->ContactRepository->find($request->get('contact'));
        $data = $this->SubscriptionRepository->findSubscription($id);
 
         if (empty($data)) {
            return false;
          } 
         elseif(!empty($product) && !empty($contact)){
           $data->setBeginDate($beginDate);
           $data->setEndDate($endDate);
           $data->setContact($this->ContactRepository->findContact($contact));
           $data->setProduct($this->ProductRepository->findProduct($product));
           $this->SubscriptionRepository->save($data);
         
           return true;
         
          }
          else return false;
    }
}