<?php

namespace App\Form;

use App\Entity\Stock;
use App\Entity\Warehouse;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StockFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('product',  EntityType::class, array(
                'class' => 'App\Entity\Product',
                'choice_label' => function ($product) {
                    return $product->getname() . ' (' . $product->getParameter() . ')';
                },
            ))
            ->add('quantity')
            ->add('warehouse', EntityType::class, [
                'class' => Warehouse::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stock::class,
        ]);
    }
}
