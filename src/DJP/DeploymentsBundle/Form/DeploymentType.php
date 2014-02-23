<?php

namespace DJP\DeploymentsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DeploymentType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('deployTime')
            ->add('project')
            ->add('environment')
            ->add('build')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DJP\DeploymentsBundle\Entity\Deployment'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'djp_deploymentsbundle_deployment';
    }
}
