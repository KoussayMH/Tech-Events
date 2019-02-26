<?php
/**
 * Created by PhpStorm.
 * User: chaym
 * Date: 2/20/2019
 * Time: 10:24 PM
 */

namespace ChaymaBundle\Controller;


use ChaymaBundle\Form\TicketType;
use ChaymaBundle\Entity\Ticket;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class TicketController extends Controller
{
public function AfficherAction(Request $request , $id)
{
    $em = $this->getDoctrine()->getManager();

   $event= $em->getRepository('KoussayBundle:Event')->find($id);

    $ticket= new Ticket();
   $ticket->setEvent($event) ;
    $form=$this->createForm(TicketType::class,$ticket);
    $form->handleRequest($request);

    if($form->isValid()){
        $em=$this->getDoctrine()->getManager();
        $em->persist($ticket);
        $em->flush();
        return $this->redirectToRoute("Commande");
    }

    // return $this->render('@Chayma/ticket.html.twig');
    return $this->render("@Chayma/ticket.html.twig",array('TicketType'=>$form->createView()));
}



    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tickets = $em->getRepository('ChaymaBundle:Ticket')->findAll();

        return $this->render('@Chayma/affticket.html.twig', array(
            'tickets' => $tickets,
        ));
    }

}