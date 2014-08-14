<?php

namespace CanalTP\SamCoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Doctrine\ORM\EntityRepository;

/**
 * Description of PerimeterType
 *
 * @author rabikhalil
 */
class PerimeterType extends AbstractType
{
    private $coverages = null;

    public function __construct($coverages)
    {
        $this->coverages = array();

        $this->fetchCoverages($coverages);
    }

    private function fetchCoverages($coverages)
    {
        foreach ($coverages as $coverage) {
            $this->coverages[$coverage->id] = $coverage->id;
        }
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'external_coverage_id',
            'choice',
            array(
                'choices' => $this->coverages,
                'empty_value' => 'global.please_choose'
            )
        );
        $builder->add(
            'external_network_id',
            'choice',
            array(
                'choices' => array(),
                'empty_value' => 'global.please_choose',
                'required'  => false
            )
        );
    }

    public function getName()
    {
        return 'perimeter';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'CanalTP\SamCoreBundle\Entity\Perimeter'
            )
        );
    }
}
