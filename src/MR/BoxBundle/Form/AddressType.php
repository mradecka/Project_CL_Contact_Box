<?php

namespace MR\BoxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('city', 'text', ['label' => 'Miasto:'])
                ->add('street', 'text', ['label' => 'Ulica:'])
                ->add('houseNumber', 'number', ['label' => 'Numer domu:'])
                ->add('flatNumber', 'number', ['label' => 'Numer mieszkania:']);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MR\BoxBundle\Entity\Address'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'mr_boxbundle_address';
    }


}
