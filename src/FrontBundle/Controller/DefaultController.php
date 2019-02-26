<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
   /* public function indexAction()
    {
        return $this->render('@Front/Default/index.html.twig');
    }*/
    public function indexAction()
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->render('@Back/default/index.html.twig');
        }
        else {
            return $this->render( '@Front/Default/index.html.twig');
        }
    }
}
