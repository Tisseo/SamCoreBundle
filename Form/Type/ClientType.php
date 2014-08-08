<?php

namespace CanalTP\SamCoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Description of ClientType
 *
 * @author kevin
 */
class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'name',
            'text',
            array(
                'label' => 'client.name'
            )
        );

        $builder->add(
            'navitiaToken',
            'text',
            array(
                'label' => 'client.navitiaToken'
            )
        );
    }
    
    public function getName()
    {
        return 'client';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'CanalTP\SamCoreBundle\Form\Model\ClientModel'
            )
        );
    }
}
