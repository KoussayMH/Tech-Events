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







}