<?php

namespace DorraBundle\Controller;

use DorraBundle\Entity\Demande;
use DorraBundle\Entity\Ressource;
use DorraBundle\Form\DemandeType;
use KoussayBundle\Entity\Event;
use KoussayBundle\KoussayBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Ressource controller.
 *
 * @Route("ressource")
 */
class RessourceController extends Controller
{
    /**
     * Lists all ressource entities.
     *
     * @Route("/", name="ressource_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ressources = $em->getRepository('DorraBundle:Ressource')->findAll();

        return $this->render('ressource/index.html.twig', array(
            'ressources' => $ressources,
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */


    /**
     * Creates a new ressource entity.
     *
     * @Route("/new", name="ressource_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $ressource = new Ressource();
        $form = $this->createForm('DorraBundle\Form\RessourceType', $ressource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ressource);
            $em->flush();

            return $this->redirectToRoute('ressource_show', array('id' => $ressource->getId()));
        }

        return $this->render('ressource/new.html.twig', array(
            'ressource' => $ressource,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ressource entity.
     *
     * @Route("/{id}", name="ressource_show")
     * @Method("GET")
     */
    public function showAction(Ressource $ressource)
    {
        $em= $this->getDoctrine()->getManager();
        $Event=$em->getRepository(Ressource::class)->findEventDQL($ressource->getId());

        $deleteForm = $this->createDeleteForm($ressource);

        return $this->render('ressource/show.html.twig', array(
            'ressource' => $ressource,
            'delete_form' => $deleteForm->createView(),
            'Event'=> $Event
        ));
    }

    /**
     * Displays a form to edit an existing ressource entity.
     *
     * @Route("/{id}/edit", name="ressource_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Ressource $ressource)
    {
        $deleteForm = $this->createDeleteForm($ressource);
        $editForm = $this->createForm('DorraBundle\Form\RessourceType', $ressource);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ressource_edit', array('id' => $ressource->getId()));
        }

        return $this->render('ressource/edit.html.twig', array(
            'ressource' => $ressource,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ressource entity.
     *
     * @Route("/{id}", name="ressource_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Ressource $ressource)
    {
        $form = $this->createDeleteForm($ressource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ressource);
            $em->flush();
        }

        return $this->redirectToRoute('ressource_index');
    }

    /**
     * Creates a form to delete a ressource entity.
     *
     * @param Ressource $ressource The ressource entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Ressource $ressource)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ressource_delete', array('id' => $ressource->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
/** ADMIN  */
    public function afficherAction()
    {

        $ressources= $this->getDoctrine()->getRepository(Ressource::class)->findAll();
        return $this->render('@Dorra/RessourcesAdmin.html.twig', array('ressources'=>$ressources));

    }
    public function SupprimerAction( $id)
    {
        $em=$this->getDoctrine()->getManager();
        $ressource= $em->getRepository(Ressource::class)->find($id);
        $em->remove($ressource);
        $em->flush();

        return $this->redirectToRoute("afficherAdmin");

    }
/** DEMANDE */
    public function createDemandeAction (Request $request, $RS)
    {
        //AFFICHAGE DES EVENTS DANS LA DEMANDE

        $em = $this->getDoctrine()->getManager();
        $listEvent = $em->getRepository('KoussayBundle:Event')->findAll();



        $Demande= new Demande();
        $form= $this->createForm(DemandeType::class, $Demande);
        $form= $form->handleRequest($request);
        if ($form->isValid())
        {
            $em= $this->getDoctrine()->getManager(); //affc
            $Demande->setEtat("Demande");
            $Demande->setRessource($RS);

            $Event= $em->getRepository(Ressource::class)->findEvent2DQL($Demande->getEvent());
            $Demande->setDateD(current($Event)->getDate());

            // $Demande->setRS($RS);
            $em->persist($Demande);
            $em->flush();//mettre a jour bdd

            return $this->redirectToRoute('readDemande', array('dateD' => $Demande->getDateD()->format('20y-m-d'), 'RS' => $RS) );//esm el routing

        }
        return $this->render('ressource/Demande.html.twig', array('form'=>$form->createView(), 'listEvent' => $listEvent) );//esm el routing

    }
    public function readDemandeAction($dateD, $RS) //tlawej levent
    {
        $em= $this->getDoctrine()->getManager();
        $Event=$em->getRepository(Demande::class)->findEventDQL($dateD, $RS);
        if ($Event)
        {
            $Demande=$em->getRepository(Demande::class)->findDemandeDQL($dateD);
            return $this->redirectToRoute('DeleteDemande', array('id' =>current($Demande)->getId() ));//esm el routing


        }
        else{

            return $this->redirectToRoute('ressource_index');//esm el routing

        }
    }
    public function deleteDemandeAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $Demande= $em->getRepository(Demande::class)->find($id);
        $em->remove($Demande);
        $em->flush();

        return $this->render('ressource/resultat.html.twig');

    }

/** RH  */
    public function afficherDemandeAction()
    {
        $liste= $this->getDoctrine()->getRepository(Demande::class)->findAll();
        return $this->render('@Dorra/ListeDemandes.html.twig', array('liste'=>$liste));

    }
    public function updateDemandeDQLAction($id, $Id_RS, $Id_Event)
    {

        // $etudiantss = new Etudiant();
        $em1= $this->getDoctrine()->getManager();
        $etudiantss=$em1->getRepository(Demande::class)
            ->AjouterEventRsDQL($Id_RS, $Id_Event);

        $em= $this->getDoctrine()->getManager();
        $etudiantss=$em->getRepository(Demande::class)
            ->AccepterDemandeDQL($id);
        return $this->redirectToRoute("listeDemandes");

    }

public function supprimerDemandeAction($id)
{
    $em=$this->getDoctrine()->getManager();
    $Demande= $em->getRepository(Demande::class)->find($id);
    $em->remove($Demande);
    $em->flush();

    return $this->redirectToRoute("listeDemandes");
}



}
