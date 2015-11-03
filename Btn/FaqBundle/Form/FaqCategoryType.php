<?php

namespace Btn\FaqBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FaqCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, array(
                'label' => 'faq_category.title',
            ))
            ->add('slug', null, array(
                'label' => 'faq_category.slug',
            ))
            ->add('visible', null, array(
                'label' => 'faq_category.visible',
            ))
            ->add('position', null, array(
                'label' => 'faq_category.position',
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Btn\FaqBundle\Entity\FaqCategory'
        ));
    }

    public function getName()
    {
        return 'btn_faqbundle_faqcategory';
    }
}
