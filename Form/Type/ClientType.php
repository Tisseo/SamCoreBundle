<?php

namespace CanalTP\SamCoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\File;
use Doctrine\ORM\EntityRepository;

/**
 * Description of ClientType
 *
 * @author kevin
 */
class ClientType extends AbstractType
{
    const MIME_IMAGETYPE_PNG = 'image/png';
    const MIME_IMAGETYPE_JPEG = 'image/jpeg';

    private $coverages = null;
    private $navitia = null;

    public function __construct($coverages, $navitia)
    {
        $this->coverages = $coverages;
        $this->navitia = $navitia;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'name',
            'text',
            array(
                'label' => 'client.name',
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
                'label' => 'client.logo_path',
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
            'navitiaToken',
            'text',
            array(
                'label' => 'client.navitia_token',
                'constraints' => array(
                    new Length(
                        array('max' => 255)
                    )
                )
            )
        );
        $builder->add(
            'applications',
            'entity',
            array(
                'label' => 'client.applications',
                'multiple' => true,
                'class' => 'CanalTPSamCoreBundle:Application',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('cli')
                        ->orderBy('cli.name', 'ASC');
                },
                'expanded' => true
            )
        );
        $builder->add(
            'perimeters',
            'collection',
            array(
                'label' => 'client.perimeters',
                'type' => new PerimeterType($this->coverages, $this->navitia),
                'prototype_name' => '__perimeter_id__',
                'allow_add' => true
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
                'data_class' => 'CanalTP\SamCoreBundle\Entity\Client'
            )
        );
    }
}
