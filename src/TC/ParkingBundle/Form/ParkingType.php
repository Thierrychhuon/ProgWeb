<?php

namespace TC\ParkingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use TC\ParkingBundle\Form\ImageType;

class ParkingType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $builder->add('adresse',      TextType::class, array('label'  =>  'Adresse du parking'))
              ->add('postcode',       IntegerType::class)
              ->add('telephone',  IntegerType::class)
              ->add('description',   TextType::class)
              ->add('image',      ImageType::class, array('label'  =>  'Veuillez entrer :'))
              ->add('submit', SubmitType::class, array('label'  =>  'Soumettre'));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TC\ParkingBundle\Entity\Parking'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tc_parkingbundle_parking';
    }


}
