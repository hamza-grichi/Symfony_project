<?php

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Subscription;
use AppBundle\Entity\Contact;
use AppBundle\Subscription\Manager\SubscriptionManager;
use AppBundle\Entity\Product;




class SubscriptionController extends FOSRestController
{
 
	 
	 /**
     * @Rest\Get("/subscription/{idContact}")
     */
    public function getAction($idContact)
    {
      
      $restresult = $this->get('app.subscription');
        if (empty($restresult->find($idContact))) {
          return new View("there are no Subscriptions exist", Response::HTTP_NOT_FOUND);
        }
      return $restresult->find($idContact);
    }


	 /**
	 * @Rest\Post("/subscription")
	 */
	 public function postAction(Request $request)
	 {
        $restresult = $this->get('app.subscription');
		  if ($restresult->save($request)) {
			return new View("subscription Added Successfully", Response::HTTP_NOT_ACCEPTABLE);           
	      }
		return new View("subscription product or contact be empty", Response::HTTP_OK);
	 }


	  /**
	 * @Rest\Put("/subscription/{id}")
	 */
	 public function updateAction($id,Request $request)
	 { 
		$restresult = $this->get('app.subscription');
		  if ($restresult->update($request,$id)) {
			return new View("subscription Updated Successfully", Response::HTTP_NOT_ACCEPTABLE);           
		  }
	    return new View("subscription not found or empty contact/product", Response::HTTP_OK);    
	 }
 
    /**
    * @Rest\Delete("/subscription/{id}")
    */
	 public function deleteAction($id)
	 {
	    $restresult = $this->get('app.subscription');
		 if (empty($restresult->delete($id))) {
		   return new View("there are no Subscriptions exist", Response::HTTP_NOT_FOUND);
		 }
	    return new View("deleted successfully", Response::HTTP_OK);
	 }
	
}
