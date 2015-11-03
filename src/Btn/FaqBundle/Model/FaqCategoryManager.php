<?php

namespace Btn\FaqBundle\Model;

use Doctrine\ORM\EntityManager;
use Knp\Component\Pager\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Btn\BaseBundle\Model\Manager;

/**
 * Faq manager
 *
 **/
class FaqCategoryManager extends Manager
{
    /**
     * Constructor.
     *
     * @param EntityManager    $em
     * @param Paginator        $paginator
     * @param Request          $request
     * @param Twig_Environment $twig
     * @param FormFactory      $formFactory
     */
    public function __construct(EntityManager $em, Paginator $paginator, \Twig_Environment $twig, $formFactory)
    {
        parent::__construct($em, $paginator, $twig, $formFactory);

        $this->repo = $this->em->getRepository('BtnFaqBundle:FaqCategory');
    }
}
