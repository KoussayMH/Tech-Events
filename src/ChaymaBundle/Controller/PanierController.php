<?php
/**
 * Created by PhpStorm.
 * User: chaym
 * Date: 2/18/2019
 * Time: 8:10 PM
 */

namespace ChaymaBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ChaymaBundle\Entity\DetailCommande;
use ChaymaBundle\Entity\Commande;

class PanierController extends Controller
{
    public function AjouterAction(Request $request,$id)
    {
        $session = $this->get('session');

        if (!$session->has('panier')) $session->set('panier',array());
        $panier = $session->get('panier');

        if (array_key_exists($id, $panier)) {
            if ($request->get('qte') != null){
                $panier[$id] = $request->get('qte');
                $this->get('session')->getFlashBag()->add('success','Quantité modifié avec succès');
            }
            else {
                $panier[$id] = $panier[$id] + 1;
            }
        } else {
            if ($request->get('qte') != null){
                $panier[$id] = $request->get('qte');
                $this->get('session')->getFlashBag()->add('success','qte ajouté avec succès');
            }
            else{
                $panier[$id] = 1;

                $this->get('session')->getFlashBag()->add('success','Article ajouté avec succès');
            }
        }

        $session->set('panier',$panier);
        $loader = new \Twig_Loader_Filesystem();
        $twig = new \Twig_Environment($loader);
        $twig->addGlobal('panier', $session->get('panier'));

        return $this->redirect($this->generateUrl('Afficher'));

    }


    public function ApplyAction()
    {

    }

    public function BasketAction()
    {
        $session = $this->get('session');
        if (!$session->has('panier')) $session->set('panier', array());

        $em = $this->getDoctrine()->getManager();
        $tickets = $em->getRepository('ChaymaBundle:Ticket')->findArray(array_keys($session->get('panier')));


        return $this->render('@Chayma/panier.html.twig', array(
            'tickets' => $tickets, 'panier' => $session->get('panier')));
    }

    public function SupprimmerAction($id)
    {
        $session = $this->get('session');
        $panier = $session->get('panier');

        if (array_key_exists($id, $panier))
        {
            if ($panier[$id]>1)
            {
                $panier[$id]=$panier[$id]-1 ;
            }
            else
            {unset($panier[$id]);}

            $session->set('panier',$panier);
        }

        return $this->redirect($this->generateUrl('Afficher'));
    }





    public function PassAction($total)
    {
        $session = $this->get('session');
        $panier = $session->get('panier');
        $em = $this->getDoctrine()->getManager();
        $tickets = $em->getRepository('ChaymaBundle:Ticket')->findArray(array_keys($session->get('panier')));
        $commande = new Commande();
        $em2 = $this->getDoctrine()->getManager();
        $commande->setTotal($total);
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        //$commande->setIdUser($user);
        $d= date_create() ;
        $commande->setDate($d);

        $em2->persist($commande);
        $em2->flush();
        foreach ($tickets as $p){
            $detailC = new DetailCommande();
            $detailC->setTicket($p);
            $detailC->setQuantite($panier[$p->getId()]);
            $detailC->setCommande($commande);
            $em1 = $this->getDoctrine()->getManager();
            $em1->persist($detailC);
            $em1->flush();
        }
       /* $em3= $this->getDoctrine()->getManager();
        $dc = $em3->getRepository('ProductBundle:DetailCommande')
            ->findby(['commande'=>$commande]);
        $this->get('knp_snappy.pdf')->generateFromHtml(
            $this->renderView(
                'ProductBundle:Commande:Facture.html.twig',
                array(
                    'dc'  => $dc,
                    'c'=>$commande,
                )
            ),
            'Facture'.$commande->getIdCommande().'.pdf'
        );*/

        $session->remove('panier');

        /* return $this->render('@Product/Commande/success.html.twig',
             array('c'=>$commande));*/

        return $this->redirect($this->generateUrl('Afficher'));



    }









}