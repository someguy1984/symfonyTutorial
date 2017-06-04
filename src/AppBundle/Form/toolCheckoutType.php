<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use AppBundle\Form\EventListener\toolCheckoutSubscriber;

class toolCheckoutType extends AbstractType
{
	
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('toolId', EntityType::class, array(
        	'class' => 'AppBundle:toolTypes',
        	'choice_label' => 'name',
        	'placeholder' => 'Choose an option',
      	));
        
        $builder->add('userId', EntityType::class, array(
        	'class' => 'AppBundle:users',
        	'choice_label' => 'username',
        	'placeholder' => 'Choose a Username',
        ));
       	
        $builder->add('quantity', IntegerType::class, array(
        	'attr' => array('min' => 1, 'max' => 100))
        );
        
        $builder->addEventSubscriber(new toolCheckoutSubscriber($options['entity_manager']));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\toolCheckout'
        ));
        
        $resolver->setRequired('entity_manager');
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_toolcheckout';
    }

}
