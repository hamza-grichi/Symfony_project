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
	   $data = new Subscription;
	   $beginDate = new \DateTime($request->get('beginDate'));
	   $endDate = new \DateTime($request->get('endDate'));
	   $product = $this->getDoctrine()->getRepository('AppBundle:Product')->find($request->get('product'));
	   $contact =  $this->getDoctrine()->getRepository('AppBundle:Contact')->find($request->get('contact'));
	
		 if(empty($product) || empty($contact))
		 {
		   return new View("subscription product or contact be empty", Response::HTTP_NOT_ACCEPTABLE); 
		 } 

		  $data->setBeginDate($beginDate);
		  $data->setEndDate($endDate);
		  $data->setContact($contact);
	      $data->setProduct($product);
		  $em = $this->getDoctrine()->getManager();
		  $em->persist($data);
		  $em->flush();
		   
		return new View("subscription Added Successfully", Response::HTTP_OK);
	 }


	  /**
	 * @Rest\Put("/subscription/{id}")
	 */
	 public function updateAction($id,Request $request)
	 { 
	   
	   $beginDate = new \DateTime($request->get('beginDate'));
	   $endDate = new \DateTime($request->get('endDate'));
	   $product = $this->getDoctrine()->getRepository('AppBundle:Product')->find($request->get('product'));
	   $contact =  $this->getDoctrine()->getRepository('AppBundle:Contact')->find($request->get('contact'));
	   $sn = $this->getDoctrine()->getManager();
	   $data = $this->getDoctrine()->getRepository('AppBundle:Subscription')->find($id);

		if (empty($data)) {
		   return new View("subscription not found", Response::HTTP_NOT_FOUND);
		 } 
		elseif(!empty($product) && !empty($contact)){
		  $data->setBeginDate($beginDate);
	      $data->setEndDate($endDate);
	      $data->setContact($this->getDoctrine()->getRepository('AppBundle:Contact')->find($contact));
	      $data->setProduct($this->getDoctrine()->getRepository('AppBundle:Product')->find($product));
	      $sn->flush();
		
		   return new View("subscription Updated Successfully", Response::HTTP_OK);
		
		 }
		 else return new View("subscription product or contact be empty", Response::HTTP_NOT_ACCEPTABLE); 
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
