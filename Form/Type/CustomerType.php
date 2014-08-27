<?php

namespace CanalTP\SamCoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Email;
use Doctrine\ORM\EntityRepository;
use CanalTP\SamCoreBundle\Form\DataTransformer\ApplicationToCustomerApplicationTransformer;

/**
 * Description of CustomerType
 *
 * @author kevin
 */
class CustomerType extends AbstractType
{
    const MIME_IMAGETYPE_PNG = 'image/png';
    const MIME_IMAGETYPE_JPEG = 'image/jpeg';

    private $coverages = null;
    private $navitia = null;
    private $applicationsTransformer = null;

    public function __construct($coverages, $navitia, $applicationsTransformer)
    {
        $this->coverages = $coverages;
        $this->navitia = $navitia;
        $this->applicationsTransformer = $applicationsTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'name',
            'text',
            array(
                'label' => 'customer.name',
                'constraints' => array(
                    new NotBlank(),
                    new Length(
                        array('max' => 255)
                    )
                )
            )
        );
        $builder->add(
            'file',
            'file',
            array(
                'label' => 'customer.logo_path',
                'required' => false,
                'constraints' => array(
                    new File(
                        array(
                            'mimeTypes' => array(
                                self::MIME_IMAGETYPE_PNG,
                                self::MIME_IMAGETYPE_JPEG
                            ),
                            'maxSize' => '8M'
                        )
                    )
                )
            )
        );
        $builder->add(
            'email',
            'text',
            array(
                'label' => 'customer.email',
                'constraints' => array(
                    new Length(
                        array('max' => 255)
                    ),
                    new Email(array('checkMX' => true))
                )
            )
        );
        $builder->add(
            'applications',
            'entity',
            array(
                'label' => 'customer.applications',
                'multiple' => true,
                'class' => 'CanalTPSamCoreBundle:Application',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('cli')
                        ->orderBy('cli.name', 'ASC');
                },
                'expanded' => true
            )
        )->addModelTransformer($this->applicationsTransformer);
        $builder->add(
            'perimeters',
            'collection',
            array(
                'label' => 'customer.perimeters',
                'type' => new PerimeterType($this->coverages, $this->navitia),
                'prototype_name' => '__perimeter_id__',
                'allow_add' => true,
                'allow_delete' => true
            )
        );
    }

    public function getName()
    {
        return 'customer';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'CanalTP\SamCoreBundle\Entity\Customer'
            )
        );
    }
}
