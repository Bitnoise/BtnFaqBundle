<?php

namespace Btn\FaqBundle\Service;

use Btn\NodesBundle\Service\NodeContentProviderInterface;
use Btn\PageBundle\Form\NodeContentType;

/**
*
*
*/
class FaqContentProvider implements NodeContentProviderInterface
{

    private $router;
    private $em;

    public function __construct($router, $em)
    {
        $this->router = $router;
        $this->em     = $em;
    }

    public function getForm()
    {
        $categories = $this->em->getRepository('BtnFaqBundle:FaqCategory')->findAll();

        $data = array();
        foreach ($categories as $category) {
            $data[$category->getId()] = $category->getTitle();
        }

        return new NodeContentType($data);
    }

    public function resolveRoute($formData = array())
    {
        return 'faq_show';
    }

    public function resolveRouteParameters($formData = array())
    {
        return array('id' => $formData['page']);
    }

    public function resolveControlRoute($formData = array())
    {
        return 'cp_faq_edit';
    }

    public function resolveControlRouteParameters($formData = array())
    {
        return array('id' => $formData['page']);
    }
}
