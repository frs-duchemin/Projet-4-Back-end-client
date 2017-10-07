<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;


class TicketType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Nom'
                ],
             ])
            ->add('firstname', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Prénom'
                ],
               ])
            ->add('country', CountryType::class, [
                'label' => false,
                'preferred_choices' => [
                    'FR'
                ]
            ])
            ->add('reduceTarif', CheckboxType::class, [
                'label' => 'tarif réduit',
                'required' => false,
                'mapped' => false,
            ])
            ->add('birthDate', DateType::class, [
                'format' => 'dd - MM - yyyy',
                'widget' => 'choice',
                'years' => range(date('Y'), date('Y') - 130),
                'attr' => [
                    'class' => 'dateNaissance',
                    'placeholder' => 'Date de naissance',
                    'readonly' => 'readonly'

                ],
                               'label' => false,
                'html5' => false
            ]);
        if (true) {
            $builder
                ->add('ticketType', ChoiceType::class, [
                    'label' => false,
                    'placeholder' => 'type de billet',
                    'choices' => [
                        'journée' => 'journee',
                        'demi-journée' => 'demi-journee',
                    ],
                'expanded' => true,
                'multiple' => false,
                'required' => true,

                ]);

        }

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Ticket'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_ticket';
    }


}
