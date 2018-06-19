<?php

namespace AppBundle\Form;


use AppBundle\Entity\Offer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

/**
 * Class OfferForm
 * @package AppBundle\Form
 */
class OfferForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->validation = $required = (isset($options['required'])) ? $options['required'] : true;
        $builder
            ->add('title', TextType::class, [
                'documentation' => [
                    'type' => 'string', // would have been automatically detected in this case
                    'description' => 'Offer title.',
                ],
                'error_bubbling' => true,
                'invalid_message' => 'You entered an invalid value, it should include letters',
                'required' => $required
            ])
            ->add('description', TextType::class, [
                'documentation' => [
                    'type' => 'string', // would have been automatically detected in this case
                    'description' => 'Offer description.',
                ],
                'error_bubbling' => true,
                'required' => $required
            ])
            ->add('email', EmailType::class, [
                'documentation' => [
                    'type' => 'string', // would have been automatically detected in this case
                    'description' => 'Offer user email, must be unique.',
                ],
                'error_bubbling' => true,
                'required' => $required
            ])
            ->add('image_url', UrlType::class, [
                'documentation' => [
                    'type' => 'string', // would have been automatically detected in this case
                    'description' => 'Offer image url.',
                ],
                'error_bubbling' => true,
                'required' => $required
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $options = [
            'data_class' => Offer::class,
            'csrf_protection' => false,
            'validation_groups' => ['POST']
        ];
        $resolver->setDefaults($options);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'offer_post';
    }
}
