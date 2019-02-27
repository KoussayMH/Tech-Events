<?php
/**
 * Created by PhpStorm.
 * User: chaym
 * Date: 2/18/2019
 * Time: 8:10 PM
 */

namespace ChaymaBundle\Controller;


use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PanierController extends Controller
{
    public function AjouterAction(Request $request,$id)
    {
        $session = $this->get('session');

        if (!$session->has('panier')) $session->set('panier',array());
        $panier = $session->get('panier');

        if (array_key_exists($id, $panier)) {
            if ($request->get('qte') != null){
                $panier[$id] =$panier[$id]+ $request->get('qte');
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

        return $this->redirect($this->generateUrl('produits_index'));

    }

    public function BasketAction()
    {
        $session = $this->get('session');
        if (!$session->has('panier')) $session->set('panier', array());

        $em = $this->getDoctrine()->getManager();
        $tickets = $em->getRepository('KoussayBundle:Event')->findArray(array_keys($session->get('panier')));


        return $this->render('ChaymaBundle:Panier:panier.html.twig', array(
            'tickets' => $tickets, 'panier' => $session->get('panier')));
    }

<<<<<<< HEAD
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

$u= $this->getUser() ;
        $d= date_create() ;
        $commande->setDate($d);
        $commande->setUser($u);

        $em2->persist($commande);
        $em2->flush();
        foreach ($tickets as $p){
            $detailC = new DetailCommande();
            $detailC->setTicket($p);
            $detailC->setQuantite($panier[$p->getId()]);
            $detailC->setCommande($commande);
            $em1 = $this->getDoctrine()->getManager();
            $em1->persist($detailC);
            $t=$em->getRepository('ChaymaBundle:Ticket')->find($p) ;
            $q=$t->getQuantite()-$panier[$p->getId()] ;
            $t->setQuantite($q) ;
            $em->persist($t) ;

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

      //  return $this->redirect($this->generateUrl('checkout'));

        return $this->render('@Chayma/checkout.html.twig', array('c'=>$commande)
        );



    }



    public function PaiementAction()
    {
        $stripe = [
            "secret_key"      => "sk_test_Zd42YheM9wlqzlmrffPMDhWL",
            "publishable_key" => "pk_test_XlvdfoLTkBc6lwi3AltjwLBa",
        ];

        \Stripe\Stripe::setApiKey($stripe['secret_key']);
        return $this->render('@Chayma/paiement.html.twig', array('stripe'=>$stripe));



    }


    public function EffectAction(Request $request, $total)
    {
         //$token  = $POST['stripeToken'];
        $stripe = [
            "secret_key"      => "sk_test_Zd42YheM9wlqzlmrffPMDhWL",
            "publishable_key" => "pk_test_XlvdfoLTkBc6lwi3AltjwLBa",
        ];

        \Stripe\Stripe::setApiKey($stripe['secret_key']);
        $token= $request->get('stripeToken') ;
        $email= $request->get('stripeEmail') ;
        //$email  = $_POST['stripeEmail'];
        $total=$total*100 ;

        $customer = \Stripe\Customer::create([
            'email' => $email,
            'source'  => $token,
        ]);
        $charge = \Stripe\Charge::create([
            'customer' => $customer->id,
            'amount'   => "$total",
            'currency' => 'usd',
        ]);

        return $this->render('@Chayma/panier.html.twig');


    }


    public function checkoutAction()
    {
        return $this->render('@Chayma/checkout.html.twig');


    }

=======
>>>>>>> 1ad5119659a4dd31671b5afad639cdd6a71e3544






}