<?php

namespace App\Form;

use App\Entity\Service;
use App\Entity\StatisticApp;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StatisticAppType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date')
//            ->add('room', EntityType::class, [
//                'required' => true,
//                'class' => Service::class,
//                'placeholder' => '',
//                'choice_label' => 'name',
//                'query_builder' => function (EntityRepository $er) {
//                    return $er
//                        ->createQueryBuilder('s')
//                        ->leftJoin('s.serviceType', 'st')
//                        ->andWhere('s.country = :country')
//                        ->setParameter('country', 'app')
//                        ->andWhere('st.name = :type')
//                        ->setParameter('type', \App\Entity\ServiceType::ROOM_SERVICES);
//                },
//            ])
//            ->add('win', TextType::class, ['label' => 'Win/Loss'])
//            ->add('account')
//            ->add('rake')
//            ->add('income')
//            ->add('currency', ChoiceType::class, [
//                'choices' => ['USD' => 'USD', 'EUR' => 'EUR', 'CNY' => 'CNY', 'RUB' => 'RUB', 'BTC' => 'BTC'],
//                'required' => false,
//                'data' => 'USD',
//            ])
//            ->add('description')
//            ->add('note', TextType::class, ['required' => false])
            ->add('submit', SubmitType::class, [
                'label' => 'Сохранить',
                'attr' => ['data-single-submit' => ''],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StatisticApp::class,
        ]);
    }
}
