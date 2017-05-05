<?php

namespace Hn\SwBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class GoodsCategorySonType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('sort')
            ->add('goodsType',EntityType::class,array(
                'class' => 'Hn\SwBundle\Entity\GoodsType',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->where('c.state = 1')
                        ->orderBy('c.sort')
                        ;
                },
                'choice_value' => 'id',
                'choice_label' => 'typeName',
                'placeholder' => '点击选择一个类型',
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Hn\SwBundle\Entity\GoodsCategory'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'hn_swbundle_goodscategory';
    }


}
