<?php
/**
 * Created by PhpStorm.
 * User: chaym
 * Date: 2/20/2019
 * Time: 5:48 PM
 */

namespace ChaymaBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CommandeController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $commandes = $em->getRepository('ChaymaBundle:Commande')->findAll();

        return $this->render('@Chayma/commande.html.twig', array(
            'commandes' => $commandes,
        ));
    }









    public function DetailsAction($id)
    {
        $em= $this->getDoctrine()->getManager() ;
        $details= $em->getRepository('ChaymaBundle:DetailCommande')->findBy(array('commande'=>$id)) ;

        return $this->render('@Chayma/detail.html.twig', array(
            'details' => $details,
        ));


    }


    public function DetailClubAction()
    {
        $em= $this->getDoctrine()->getManager() ;
        $user= $this->getUser() ;
        $details= $em->getRepository('ChaymaBundle:DetailCommande')->findBy(array('user'=>$user)) ;
        return $this->render('@Chayma/detailClub.html.twig', array(
            'details' => $details,
        ));

    }


}