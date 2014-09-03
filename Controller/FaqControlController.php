<?php

namespace Btn\FaqBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Btn\FaqBundle\Entity\Faq;
use Btn\FaqBundle\Form\FaqFilterType;

/**
 * Faq controller.
 *
 * @Route("/control/faq")
 */
class FaqControlController extends Controller
{
    /**
     * Lists all Faq entities.
     *
     * @Route("/", name="cp_faq")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $manager = $this->get('btn.faq.manager')
            ->setRequest($request)
            ->setNs('control_faq')
            ->createForm(new FaqFilterType())
            ->filter()
            ->paginate(10)
        ;

        return array(
            'pagination' => $manager->getPagination(),
            'filter_form' => $manager->getForm()->createView(),
        );
    }

    /**
     * Finds and displays a Faq entity.
     *
     * @Route("/{id}/show", name="cp_faq_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BtnFaqBundle:Faq')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Faq entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Faq entity.
     *
     * @Route("/new", name="cp_faq_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Faq();
        $form   = $this->createForm('btn_faqbundle_faq', $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Faq entity.
     *
     * @Route("/create", name="cp_faq_create")
     * @Method("POST")
     * @Template("BtnFaqBundle:FaqControl:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Faq();
        $form = $this->createForm('btn_faqbundle_faq', $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $msg = $this->get('translator')->trans('crud.flash.saved');
            $this->getRequest()->getSession()->getFlashBag()->set('success', $msg);

            return $this->redirect($this->generateUrl('cp_faq_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Faq entity.
     *
     * @Route("/{id}/edit", name="cp_faq_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BtnFaqBundle:Faq')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Faq entity.');
        }

        $editForm = $this->createForm('btn_faqbundle_faq', $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Faq entity.
     *
     * @Route("/{id}/update", name="cp_faq_update")
     * @Method("POST")
     * @Template("BtnFaqBundle:FaqControl:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BtnFaqBundle:Faq')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Faq entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm('btn_faqbundle_faq', $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $msg = $this->get('translator')->trans('crud.flash.saved');
            $this->getRequest()->getSession()->getFlashBag()->set('success', $msg);

            return $this->redirect($this->generateUrl('cp_faq_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Faq entity.
     *
     * @Route("/{id}/delete", name="cp_faq_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BtnFaqBundle:Faq')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Faq entity.');
            }

            $em->remove($entity);
            $em->flush();

            $msg = $this->get('translator')->trans('crud.flash.deleted');
            $this->getRequest()->getSession()->getFlashBag()->set('success', $msg);
        }

        return $this->redirect($this->generateUrl('cp_faq'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
