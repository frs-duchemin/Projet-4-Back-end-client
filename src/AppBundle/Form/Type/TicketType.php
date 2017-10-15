<?php

namespace AppBundle\Form\Type;

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
                    'label' => 'form.name',
                    'attr' => [
                        'placeholder' => 'form.name'
                    ],
                ])

                ->add('firstname', TextType::class, [
                    'label' => 'form.firstname',
                    'attr' => [
                    'placeholder' => 'form.firstname'
                    ],
                ])

                ->add('country', CountryType::class, [
                    'label' => 'form.country',
                    'preferred_choices' =>'app.request.locale',
                ])

                ->add('reduceTarif', CheckboxType::class, [
                    'label' => 'form.reduce.price',
                    'required' => false,
                    'mapped' => false,
                ])

                ->add('birthDate', DateType::class, [
                    'format' => 'dd - MM - yyyy',
                    'widget' => 'choice',
                    'years' => range(date('Y'), date('Y') - 130),
                    'attr' => [
                        'readonly' => 'readonly'
                    ],
                    'label' => 'form.birthdate',
                    'html5' => false
                ])

                ->add('ticketType', ChoiceType::class, [
                    'label' => 'form.choice',
                    'choices' => [
                        'form.day' => 'journee',
                        'form.halfday' => 'demi-journee',
                    ],
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true,
                   
                ]);

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
            return 'ticket';
        }

}
