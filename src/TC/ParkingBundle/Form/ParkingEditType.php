<?php
// src/OC/PlatformBundle/Form/AdvertEditType.php
namespace TC\ParkingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ParkingEditType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    
  }
  public function getParent()
  {
    return ParkingType::class;
  }
}
