<?php

namespace Btn\FaqBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Doctrine\ORM\EntityRepository;
use Btn\BaseBundle\Util\Form;

use Doctrine\ORM\Query\Expr;

class FaqFilterType extends AbstractType
{
    protected $filters = array(
                  'keyword'    => 'f.question',
                  'category'   => 'f.category_id'
              );

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('keyword', 'text', array('label' => 'Keyword', 'required' => false))
            ->add('category', 'entity', array(
                'empty_value' => 'faq.filter_category_all',
                'label'       => 'faq.filter_category',
                'class'       => 'Btn\FaqBundle\Entity\FaqCategory',
                'query_builder' => function (EntityRepository $em) {
                    return $em
                        ->createQueryBuilder('fc')
                        ->join('Btn\FaqBundle\Entity\Faq', 'f', Expr\Join::WITH, 'f.category = fc.id')
                        ->orderBy('fc.position')
                    ;
                },
                'property' => 'title',
                'required' => false,
                'expanded' => false,
            ))
        ;
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'csrf_protection' => false
        );
    }

    public function getName()
    {
        return 'filter';
    }

    public function getKeyword($keyword, $expr)
    {
        return $expr->orx($expr->like('f.question', $expr->literal('%'.$keyword.'%')));
    }

    public function getCategory($category, $expr)
    {
        return $expr->eq('f.category', is_object($category) ? $category->getId() : (int) $category);
    }

    public function getExpr($bindedData, $expr)
    {
        return Form::getExpr($bindedData, $expr, $this->filters, $this);
    }
}
