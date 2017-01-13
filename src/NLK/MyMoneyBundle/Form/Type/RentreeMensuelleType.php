<?php

namespace NLK\MyMoneyBundle\Form\Type;

use NLK\MyMoneyBundle\Entity\Exercice;
use NLK\MyMoneyBundle\Repository\ExerciceRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RentreeMensuelleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('montant')
            ->add('exercice', EntityType::class, array(
                'class'        => 'NLKMyMoneyBundle:Exercice',
                'query_builder' => function(ExerciceRepository $er)
                                   {
                                        return $er->getListExercices();
                                    },
                'choice_label' => function(Exercice $exercice) {
                /** @var Category $category */
                    return $exercice->getAnnee() . ' - ' . $exercice->getMonthName();
                },
                'multiple'     => false,
                'expanded'     => false,  
              ))  
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
            'data_class' => 'NLK\MyMoneyBundle\Entity\RentreeMensuelle'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'nlk_mymoneybundle_rentreemensuelle';
    }


}
