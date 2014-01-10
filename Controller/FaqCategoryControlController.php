<?php

namespace Btn\FaqBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Btn\FaqBundle\Entity\FaqCategory;
use Btn\FaqBundle\Form\FaqCategoryType;

/**
 * FaqCategory controller.
 *
 * @Route("/control/faqcategory")
 */
class FaqCategoryControlController extends Controller
{
    /**
     * Lists all FaqCategory entities.
     *
     * @Route("/", name="cp_faqcategory")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $manager = $this->get('btn.faqcategory.manager')
            ->setRequest($request)
            ->setNs('control_faqcategory')
            // ->createForm(new FaqCategoryFilterType())
            // ->filter()
            ->paginate(10)
        ;

        return array(
            'pagination' => $manager->getPagination(),
        );
    }

    /**
     * Finds and displays a FaqCategory entity.
     *
     * @Route("/{id}/show", name="cp_faqcategory_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BtnFaqBundle:FaqCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FaqCategory entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new FaqCategory entity.
     *
     * @Route("/new", name="cp_faqcategory_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new FaqCategory();
        $form   = $this->createForm(new FaqCategoryType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new FaqCategory entity.
     *
     * @Route("/create", name="cp_faqcategory_create")
     * @Method("POST")
     * @Template("BtnFaqBundle:FaqCategory:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new FaqCategory();
        $form = $this->createForm(new FaqCategoryType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $msg = $this->get('translator')->trans('crud.flash.saved');
            $this->getRequest()->getSession()->getFlashBag()->set('success', $msg);

            return $this->redirect($this->generateUrl('cp_faqcategory_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing FaqCategory entity.
     *
     * @Route("/{id}/edit", name="cp_faqcategory_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BtnFaqBundle:FaqCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FaqCategory entity.');
        }

        $editForm = $this->createForm(new FaqCategoryType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing FaqCategory entity.
     *
     * @Route("/{id}/update", name="cp_faqcategory_update")
     * @Method("POST")
     * @Template("BtnFaqBundle:FaqCategory:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BtnFaqBundle:FaqCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FaqCategory entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new FaqCategoryType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $msg = $this->get('translator')->trans('crud.flash.saved');
            $this->getRequest()->getSession()->getFlashBag()->set('success', $msg);

            return $this->redirect($this->generateUrl('cp_faqcategory_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a FaqCategory entity.
     *
     * @Route("/{id}/delete", name="cp_faqcategory_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BtnFaqBundle:FaqCategory')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find FaqCategory entity.');
            }

            $em->remove($entity);
            $em->flush();

            $msg = $this->get('translator')->trans('crud.flash.deleted');
            $this->getRequest()->getSession()->getFlashBag()->set('success', $msg);
        }

        return $this->redirect($this->generateUrl('cp_faqcategory'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
