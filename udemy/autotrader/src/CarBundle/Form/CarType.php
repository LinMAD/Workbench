<?php

namespace CarBundle\Form;

use CarBundle\Entity\Make;
use CarBundle\Entity\Model;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Exception\AccessException;
use Symfony\Component\OptionsResolver\OptionsResolver;
use CarBundle\Entity\Car;
use Symfony\Component\Validator\Constraints\NotBlank;

class CarType extends AbstractType
{
    /**
     * {@inheritdoc}
     * @throws \Symfony\Component\Validator\Exception\MissingOptionsException
     * @throws \Symfony\Component\Validator\Exception\ConstraintDefinitionException
     * @throws \Symfony\Component\Validator\Exception\InvalidOptionsException
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('price', TextType::class, [
                'required'    => true,
                'constraints' => new NotBlank(),
            ])
            ->add('year', TextType::class, [
                'required'    => true,
                'constraints' => new NotBlank(),
            ])
            ->add('navigation')
            ->add('description')
            ->add('model', EntityType::class, [
                'required' => true,
                'class'    => Model::class,
            ])
            ->add('make', EntityType::class, [
                'required' => true,
                'class'    => Make::class,
            ]);
    }

    /**
     * {@inheritdoc}
     *
     * @throws AccessException
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'carbundle_car';
    }


}
