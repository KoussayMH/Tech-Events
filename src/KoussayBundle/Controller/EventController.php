<?php

namespace KoussayBundle\Controller;

use KoussayBundle\Entity\Comment;
use KoussayBundle\Entity\Event;
use KoussayBundle\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

/**
 * Event controller.
 *
 * @Route("event")
 */
class EventController extends Controller
{
    /**
     * Lists all event entities.
     *
     * @Route("/", name="event_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $events=$em->getRepository(Event::class)
            ->findEventDQL();
        return $this->render('event/index.html.twig', array(
            'events' => $events,
        ));
    }

    /**
     * Creates a new event entity.
     *
     * @Route("/new", name="event_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $event = new Event();
        $form = $this->createForm('KoussayBundle\Form\EventType', $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /**
             * @var UploadedFile $file
             */
            $file=$event->getImage1();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
            $this->getParameter('image_directory'),$fileName
            );
            $event->setImage1($fileName);


            $em = $this->getDoctrine()->getManager();
            $event->setEtat("enAttente");
            $em->persist($event);

            $em->flush();

            return $this->redirectToRoute('event_index');
        }

        return $this->render('event/new.html.twig', array(
            'event' => $event,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a event entity.
     *
     * @Route("/{id}", name="event_show")
     * @Method("GET")
     */
    public function showAction(Event $event,Request $request )
    {

        $comment= new Comment();
        $form_Commetaire= $this->createForm(CommentType::class, $comment);
        $form_Commetaire= $form_Commetaire->handleRequest($request);
        if ($form_Commetaire->isValid())
        {
            $em= $this->getDoctrine()->getManager(); //affc
            $em->persist($comment);
            $comment->setMaxcaracs(50);
            $comment->setEvent($event);
            $comment->setDate(new \DateTime());

            $em->flush();//mettre a jour bdd
        }

        $em = $this->getDoctrine()->getManager();
        $comments=$em->getRepository(Event::class)->findCommentDQL($event->getId());

        $deleteForm = $this->createDeleteForm($event);

        return $this->render('event/show.html.twig', array(
            'event' => $event,
            'delete_form' => $deleteForm->createView(),
            'comments' => $comments,
            'form_Commetaire' => $form_Commetaire->createView() ,

        ));



    }

    /**
     * Displays a form to edit an existing event entity.
     *
     * @Route("/{id}/edit", name="event_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Event $event)
    {
        $deleteForm = $this->createDeleteForm($event);
        $editForm = $this->createForm('KoussayBundle\Form\EventType', $event);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event_edit', array('id' => $event->getId()));
        }

        return $this->render('event/edit.html.twig', array(
            'event' => $event,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a event entity.
     *
     * @Route("/{id}", name="event_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Event $event)
    {
        $form = $this->createDeleteForm($event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($event);
            $em->flush();
        }

        return $this->redirectToRoute('event_index');
    }

    /**
     * Creates a form to delete a event entity.
     *
     * @param Event $event The event entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Event $event)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('event_delete', array('id' => $event->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


    public function readAction()
    {
        $event= $this->getDoctrine()->getRepository(Event::class)->findAll();
        return $this->render('@Koussay/admin.html.twig', array('event'=>$event));
    }

    public function deleteAAction( $id)
    {
        $em=$this->getDoctrine()->getManager();
        $event= $em->getRepository(Event::class)->find($id);
        $em->remove($event);
        $em->flush();

        return $this->redirectToRoute("dataTable");

    }

    public function updateDemandeDQLAction($id)
    {

        $em= $this->getDoctrine()->getManager();
        $etudiantss=$em->getRepository(Event::class)
            ->AccepterDemandeDQL($id);
        return $this->redirectToRoute("dataTable");

    }


}
