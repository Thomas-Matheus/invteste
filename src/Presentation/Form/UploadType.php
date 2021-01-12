<?php

namespace App\Presentation\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;

class UploadType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('shipOrders', FileType::class, [
                'label' => 'Ship Order file',
                'attr' => [
                    'class' => 'form-control'
                ],
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/xml',
                            'text/xml',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid XML File',
                    ])
                ],
            ])
            ->add('people', FileType::class, [
                'label' => 'People file',
                'attr' => [
                    'class' => 'form-control'
                ],
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/xml',
                            'text/xml',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid XML File',
                    ])
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Submit',
                'attr' => [
                    'class' => 'w-100 btn btn-primary btn-lg'
                ],
            ]);
    }
}
