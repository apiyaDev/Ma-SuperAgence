<?php

namespace App\Form;

use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Option;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('surface')
            ->add('rooms')
            ->add('bedrooms')
            ->add('floor')
            ->add('heat', ChoiceType::class, [
                'choices' => $this->getChoiceHeat()
            ])
            ->add('options', EntityType::class, [
                'class' => Option::class,
                'choice_label' => 'name',
                'multiple' => true
            ])
            ->add('imageFile', FileType::class, [
                'required' => false
            ])
            ->add('city')
            ->add('adresse')
            ->add('postal_code')
            ->add('sold')
            ->add('price')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }

    private function getChoiceHeat()
    {
        $choices = Property::HEAT;
        $output = [];
        foreach ($choices as $k => $v) 
        {
            $output[$v] = $k;
        }
        return $output;

    }

}
