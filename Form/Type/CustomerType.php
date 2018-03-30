<?php

namespace CanalTP\SamCoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;

/**
 * Description of CustomerType
 *
 * @author kevin
 */
class CustomerType extends AbstractType
{
    const MIME_IMAGETYPE_PNG = 'image/png';
    const MIME_IMAGETYPE_JPEG = 'image/jpeg';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'name',
            TextType::class,
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
            FileType::class,
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
            EmailType::class,
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
            'identifier',
            TextType::class,
            array(
                'label' => 'customer.identifier',
                'constraints' => array(
                    new NotBlank(),
                    new Length(
                        array('max' => 255)
                    ),
                    new Regex(
                        array('pattern' => '/^[a-zA-Z0-9]+$/')
                    )
                ),
                'disabled' => array_key_exists('data', $options)
            )
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'CanalTP\SamCoreBundle\Entity\Customer'
            )
        );
    }

    public function getName()
    {
        $this->getBlockPrefix();
    }

    public function getBlockPrefix() {
        return 'customer';
    }
}
