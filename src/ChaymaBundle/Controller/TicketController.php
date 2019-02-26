<?php
/**
 * Created by PhpStorm.
 * User: chaym
 * Date: 2/20/2019
 * Time: 10:24 PM
 */

namespace ChaymaBundle\Controller;


use ChaymaBundle\ChaymaBundle;
use ChaymaBundle\Form\TicketType;
use ChaymaBundle\Entity\Ticket;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Endroid\QrCode\QrCode;


class TicketController extends Controller
{
public function AjouterAction(Request $request , $id)
{
    $em = $this->getDoctrine()->getManager();

   $event= $em->getRepository('KoussayBundle:Event')->find($id);
   $club= $event->getClub() ;

    $ticket= new Ticket();
   $ticket->setEvent($event) ;
    $form=$this->createForm(TicketType::class,$ticket);
    $form->handleRequest($request);

    if($form->isValid()){
        $u= $this->getUser() ;
        $ticket->setUser($u) ;
        $ticket->setClub($club) ;
        $em=$this->getDoctrine()->getManager();
        $em->persist($ticket);
        $em->flush();
        return $this->redirectToRoute("Commande");
    }

    // return $this->render('@Chayma/ticket.html.twig');
    return $this->render("@Chayma/ticket.html.twig",array('TicketType'=>$form->createView()));
}


    public function AffeventAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $tickets= $em->getRepository('ChaymaBundle:Ticket')->findBy(array('event'=>$id));



        // return $this->render('@Chayma/ticket.html.twig');
        return $this->render("@Chayma/ticketevent.html.twig",array('tickets'=>$tickets));
    }



    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tickets = $em->getRepository('ChaymaBundle:Ticket')->findAll();

        return $this->render('@Chayma/affticket.html.twig', array(
            'tickets' => $tickets,
        ));
    }


    public  function qrcodeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $ticket = $em->getRepository('ChaymaBundle:DetailCommande')->find($id);
                $t="Commande Num:".$ticket->getCommande()."Code Ticket ".$ticket->getTicket() ;
        $qrCode = new QrCode($t);
        header('Content-Type: '.$qrCode->getContentType());
        return $this->render('@Chayma/qrcode.html.twig', array(
            'qrcode' => $qrCode,
        ));

    }



    public function editAction(Request $request,  $id )
    {
        $em = $this->getDoctrine()->getManager();
        $ticket = $em->getRepository('ChaymaBundle:Ticket')->find($id);

      //  $deleteForm = $this->createDeleteForm($ticket);
        $editForm = $this->createForm(TicketType::class, $ticket);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('AffTicket');
        }

        return $this->render('@Chayma/editTicket.html.twig', array(

            'TicketType' => $editForm->createView(),

        ));
    }





    public function deleteAction($id)
    {

            $em = $this->getDoctrine()->getManager();
           $ticket= $em->getRepository('ChaymaBundle:Ticket')->find($id);
           $em->remove($ticket) ;
            $em->flush();


        return $this->redirectToRoute('AffTicket');
    }























}