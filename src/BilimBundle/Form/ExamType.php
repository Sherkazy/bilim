<?php

namespace BilimBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExamType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        global $kernel;

        if ( 'AppCache' == get_class($kernel) )
        {
            $kernel = $kernel->getKernel();
        }
        $doctrine = $kernel->getContainer()->get( 'doctrine' );

        $entities=$doctrine->getRepository('BilimBundle:Suroo')
            ->findAll();


        $suroo = array();

        foreach ($entities as $entity){
            $suroo[$entity->getId()] = $entity->getId();
        }

        $builder
            ->add('test')
            ->add('suroo', 'choice', array(
                'label' => 'Суроолор',
//                'attr'=>array('class'=>'col-md-4'),
                'choices' => $suroo,
                'multiple' => true,
                'required' => false,
                'expanded' => true
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BilimBundle\Entity\Exam'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'bilimbundle_exam';
    }


}
