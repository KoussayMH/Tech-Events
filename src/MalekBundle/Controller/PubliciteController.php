<?php

namespace MalekBundle\Controller;

use MalekBundle\Entity\Publicite;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Publicite controller.
 *
 * @Route("publicite")
 */
class PubliciteController extends Controller
{
    /**
     * Lists all publicite entities.
     *
     * @Route("/", name="publicite_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $publicites = $em->getRepository('MalekBundle:Publicite')->findAll();

        return $this->render('publicite/index.html.twig', array(
            'publicites' => $publicites,
        ));
    }

    /**
     * Creates a new publicite entity.
     *
     * @Route("/new", name="publicite_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $publicite = new Publicite();
        $form = $this->createForm('MalekBundle\Form\PubliciteType', $publicite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($publicite);
            $publicite->setImageSize(50);
            $em->flush();

            return $this->redirectToRoute('publicite_show', array('id' => $publicite->getId()));
        }

        return $this->render('publicite/new.html.twig', array(
            'publicite' => $publicite,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a publicite entity.
     *
     * @Route("/{id}", name="publicite_show")
     * @Method("GET")
     */
    public function showAction(Publicite $publicite)
    {
        $deleteForm = $this->createDeleteForm($publicite);

        return $this->render('publicite/show.html.twig', array(
            'publicite' => $publicite,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing publicite entity.
     *
     * @Route("/{id}/edit", name="publicite_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Publicite $publicite)
    {
        $deleteForm = $this->createDeleteForm($publicite);
        $editForm = $this->createForm('MalekBundle\Form\PubliciteType', $publicite);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('publicite_edit', array('id' => $publicite->getId()));
        }

        return $this->render('publicite/edit.html.twig', array(
            'publicite' => $publicite,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a publicite entity.
     *
     * @Route("/{id}", name="publicite_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Publicite $publicite)
    {
        $form = $this->createDeleteForm($publicite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($publicite);
            $em->flush();
        }

        return $this->redirectToRoute('publicite_index');
    }

    /**
     * Creates a form to delete a publicite entity.
     *
     * @param Publicite $publicite The publicite entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Publicite $publicite)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('publicite_delete', array('id' => $publicite->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    public function AfficherPubAction()
    {
        $publicites= $this->getDoctrine()->getRepository(publicite::class)->findPubliciteDQL();
        return $this->render('@Malek/AffichPub.html.twig', array('pub'=>$publicites));
    }






}
