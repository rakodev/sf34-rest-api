<?php

namespace AppBundle\Form;


use AppBundle\FormModel\Offer;
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
        $builder
            ->add('title', TextType::class, [
                'label' => 'Title',
                'error_bubbling' => true
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'error_bubbling' => true
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'error_bubbling' => true
            ])
            ->add('image_url', UrlType::class, [
                'label' => 'Image URL',
                'error_bubbling' => true
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Offer::class,
            'csrf_protection' => false,
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'offer_post';
    }
}
