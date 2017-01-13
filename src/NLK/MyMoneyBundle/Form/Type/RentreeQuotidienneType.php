<?php

namespace NLK\MyMoneyBundle\Form\Type;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RentreeQuotidienneType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date')
            ->add('name')
            ->add('montant')
            ->add('categorie', EntityType::class, array(
                'class'        => 'NLKMyMoneyBundle:CategorieCredit',
                'choice_label' => 'name',
                'multiple'     => false,
                'expanded'     => false,  
              )) 
            ->add('Ajouter',      SubmitType::class)
            ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NLK\MyMoneyBundle\Entity\RentreeQuotidienne'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'nlk_mymoneybundle_rentreequotidienne';
    }


}
