<?php
// src/AppBundle/Form/EventListener/toolCheckoutSubscriber.php
namespace AppBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityManager;

class toolCheckoutSubscriber implements EventSubscriberInterface
{
	private $em;
	
	public function __construct(EntityManager $em) {
		$this->em = $em;
	}
	
	public static function getSubscribedEvents()
	{
		// Tells the dispatcher that you want to listen on the form.pre_set_data
		// event and that the preSetData method should be called.
		return array(FormEvents::SUBMIT => 'preSetData');
	}
	
	public function preSetData(FormEvent $event)
	{
		$data = $event->getData();
		$form = $event->getForm();
		
		/*Validation Before Form is Submitted: Confirm the totals available in store against required ammounts*/
		$toolStore = $this->em->getRepository('AppBundle:toolStore')->findOneBy(array( 'toolId' => $data->getToolId() ));
		if ($toolStore->getQuantity() <= $data->getQuantity() && $data->getQuantity() > 0) {
			die ('Sorry there are: '.$toolStore->getQuantity().' '.$toolStore->getToolId()->getName().'\'s available in the store, you requested: '.$data->getQuantity().'.');	
		}
	}
}