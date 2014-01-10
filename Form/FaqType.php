<?php

namespace Btn\FaqBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FaqType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('question', null, array(
                'label' => 'faq.question',
            ))
            ->add('answer', null, array(
                'label' => 'faq.answer',
                'attr' => array(
                    'rows' => 8,
                ),
            ))
            ->add('visible', null, array(
                'label' => 'faq.visible',
            ))
            ->add('position', null, array(
                'label' => 'faq.position',
            ))
            ->add('category', null, array(
                'label' => 'faq.category',
                'empty_value' => 'faq.category_empty_value',
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Btn\FaqBundle\Entity\Faq'
        ));
    }

    public function getName()
    {
        return 'btn_faqbundle_faq';
    }
}
