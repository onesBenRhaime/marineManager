<?php

namespace App\Form;

use App\Entity\Bateaux;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BateauxType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Mat')
            ->add('port')
            ->add('type')
            ->add('longeur')
            ->add('largeur')
            ->add('hauteur')
            ->add('numserie')
            ->add('marque')
            ->add('tonnage')
            ->add('save',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bateaux::class,
        ]);
    }
}
