<?php

namespace AppBundle\Controller;

use AppBundle\Entity\toolCheckout;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * Toolcheckout controller.
 *
 * @Route("/")
 */
class toolCheckoutController extends Controller
{
    /**
     * Lists all toolCheckout entities.
     *
     * @Route("/", name="_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $toolCheckouts = $em->getRepository('AppBundle:toolCheckout')->findAll();

        return $this->render('toolcheckout/index.html.twig', array(
            'toolCheckouts' => $toolCheckouts,
        ));
    }

    /**
     * Creates a new toolCheckout entity.
     *
     * @Route("/new", name="_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	
    	//Handle the Json request from the page
    	if ($request->isXmlHttpRequest()) {	
    		$result = $em->getRepository('AppBundle:toolStore')->findOneBy(array( 'toolId' => $request->get('id') ));
    		return new JsonResponse(array('value' => $result->getQuantity()));
    	}
    	
    	//Establish a new form on the page
    	$toolCheckout = new Toolcheckout();
    	$form = $this->createForm('AppBundle\Form\toolCheckoutType', $toolCheckout, array('entity_manager' => $em));
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($toolCheckout);
            
            //Validate wether this username has checked out this item before
            $valid = $em->getRepository('AppBundle:toolCheckout')->findOneBy(array( 'toolId' => $toolCheckout->getToolId(), 'userId' => $toolCheckout->getUserId()));
            if ($valid !== null) return $this->redirectToRoute('_show', array('id' => $valid->getId()));
            
            //Access the remove tools function
            $toolStore = $em->getRepository('AppBundle:toolStore');
            $toolStore->removeTools($toolCheckout->getToolId(), $toolCheckout->getQuantity());
           	
            $em->flush();
            return $this->redirectToRoute('_show', array('id' => $toolCheckout->getId()));
        }
		
        return $this->render('toolcheckout/new.html.twig', array(
            'toolCheckout' => $toolCheckout,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a toolCheckout entity.
     *
     * @Route("/{id}", name="_show")
     * @Method("GET")
     */
    public function showAction(toolCheckout $toolCheckout)
    {
        $deleteForm = $this->createDeleteForm($toolCheckout);

        return $this->render('toolcheckout/show.html.twig', array(
            'toolCheckout' => $toolCheckout,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing toolCheckout entity.
     *
     * @Route("/{id}/edit", name="_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, toolCheckout $toolCheckout)
    {
        $deleteForm = $this->createDeleteForm($toolCheckout);
        $editForm = $this->createForm('AppBundle\Form\toolCheckoutType', $toolCheckout, array('entity_manager' => $em));
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('_edit', array('id' => $toolCheckout->getId()));
        }

        return $this->render('toolcheckout/edit.html.twig', array(
            'toolCheckout' => $toolCheckout,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a toolCheckout entity.
     *
     * @Route("/{id}", name="_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, toolCheckout $toolCheckout)
    {
        $form = $this->createDeleteForm($toolCheckout);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        	//Access the add tools function
        	$em = $this->getDoctrine()->getManager();
        	$toolStore = $em->getRepository('AppBundle:toolStore');
        	$toolStore->addTools($toolCheckout->getToolId(), $toolCheckout->getQuantity());
        	
            $em = $this->getDoctrine()->getManager();
            $em->remove($toolCheckout);
            $em->flush();
        }

        return $this->redirectToRoute('_index');
    }

    /**
     * Creates a form to delete a toolCheckout entity.
     *
     * @param toolCheckout $toolCheckout The toolCheckout entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(toolCheckout $toolCheckout)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('_delete', array('id' => $toolCheckout->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
