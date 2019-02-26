<?php

namespace MalekBundle\Controller;

use MalekBundle\Entity\SMS;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Sm controller.
 *
 * @Route("sms")
 */
class SMSController extends Controller
{
    /**
     * Lists all sM entities.
     *
     * @Route("/", name="sms_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sMSs = $em->getRepository('MalekBundle:SMS')->findAll();

        return $this->render('sms/index.html.twig', array(
            'sMSs' => $sMSs,
        ));
    }

    /**
     * Creates a new sM entity.
     *
     * @Route("/new", name="sms_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $sM = new Sm();
        $form = $this->createForm('MalekBundle\Form\SMSType', $sM);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sM);
            $em->flush();

            return $this->redirectToRoute('sms_show', array('id' => $sM->getId()));
        }

        return $this->render('sms/new.html.twig', array(
            'sM' => $sM,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a sM entity.
     *
     * @Route("/{id}", name="sms_show")
     * @Method("GET")
     */
    public function showAction(SMS $sM)
    {
        $deleteForm = $this->createDeleteForm($sM);

        return $this->render('sms/show.html.twig', array(
            'sM' => $sM,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing sM entity.
     *
     * @Route("/{id}/edit", name="sms_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SMS $sM)
    {
        $deleteForm = $this->createDeleteForm($sM);
        $editForm = $this->createForm('MalekBundle\Form\SMSType', $sM);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sms_edit', array('id' => $sM->getId()));
        }

        return $this->render('sms/edit.html.twig', array(
            'sM' => $sM,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a sM entity.
     *
     * @Route("/{id}", name="sms_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SMS $sM)
    {
        $form = $this->createDeleteForm($sM);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($sM);
            $em->flush();
        }

        return $this->redirectToRoute('sms_index');
    }

    /**
     * Creates a form to delete a sM entity.
     *
     * @param SMS $sM The sM entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SMS $sM)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sms_delete', array('id' => $sM->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
