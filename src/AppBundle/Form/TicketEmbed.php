<?php
/**
 * Created by PhpStorm.
 * User: Frs
 * Date: 22/09/2017
 * Time: 23:33
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class TicketEmbed extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tickets', CollectionType::class, [
                'entry_type'   => TicketType::class,
                'allow_add'    => true,
                'allow_delete' => true,
                'label'        => ' ',
                'by_reference' => false
            ])
            ->add('Valider', SubmitType::class, [
                'attr' => ['class' => 'btn btn-danger btn-lg']
            ])
        ;
    }
}