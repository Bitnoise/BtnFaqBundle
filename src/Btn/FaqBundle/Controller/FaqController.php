<?php

namespace Btn\FaqBundle\Controller;

use Btn\BaseBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Btn\FaqBundle\Entity\FaqCategory;

class FaqController extends BaseController
{
    /**
     * @var integer
     */
    protected $perPage = 20;

    /**
     *
     */
    protected function getBaseReturn()
    {
        return array(
            'categories' => $this->getRepository('BtnFaqBundle:FaqCategory')->findAllVisible(),
        );
    }

    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;
    }

    public function getPerPage()
    {
        return $this->perPage;
    }

    /**
     * @Route("faq", name="faq")
     * @Template()
     */
    public function indexAction()
    {
        return $this->getBaseReturn();
    }

    /**
     * @Route("/faq/search", name="faq_search")
     * @Template()
     */
    public function searchAction(Request $request)
    {
        $return = $this->getBaseReturn();

        $return['faqs'] = $this->get('knp_paginator')->paginate(
            $this->getRepository('BtnFaqBundle:Faq')->getFindByStringQuery($request->get('string')),
            $request->query->get('page', 1),
            $this->getPerPage()
        );

        return $return;
    }

    /**
     * @Route("faq/{id}", name="faq_show", requirements={"id" = "\d+"})
     * @Route("faq/{slug}", name="faq_show_slug", requirements={"slug" = "[a-zA-Z0-9\-]+"})
     * @ParamConverter("category", class="BtnFaqBundle:FaqCategory")
     * @Template()
     */
    public function showAction(Request $request, FaqCategory $category)
    {
        $return = $this->getBaseReturn();
        $return['category'] = $category;

        $return['faqs'] = $this->get('knp_paginator')->paginate(
            $this->getRepository('BtnFaqBundle:Faq')->getFindVisibleForCategoryQuery($category),
            $request->query->get('page', 1),
            $this->getPerPage()
        );

        return $return;
    }
}
