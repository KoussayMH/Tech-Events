<?php

namespace IhebBundle\Controller;
use IhebBundle\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


class NotificationController extends Controller
{

    function AllNotificationJsonAction(Request $request){
        $output = [];
        $plein_text = $request->get('plein_text');
        $repository = $this->getDoctrine()->getRepository(Notification::class);
        $results=$repository->createQueryBuilder('a')
            ->where("a.idUser = '$plein_text'")
            ->getQuery()->getArrayResult();

        $count = $repository->createQueryBuilder('v')
            ->where("v.status = '0'")
            ->andWhere("v.idUser ='$plein_text'")
            ->select('count(v.id)')
            ->getQuery()
            ->getSingleScalarResult();

        if($results!= null || !empty($results)){
            if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
                $header='<a class="dropdown-item">
                            <p class="mb-0 font-weight-normal float-left">You have '.$count.' new notifications
                            </p>
                        </a>
                        <div class="dropdown-divider"></div>';
                array_push($output , $header);
            }

            foreach ($results as $notif){
                if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
                    $o=' 
                        
                        <a class="dropdown-item preview-item">
                            <div class="preview-thumbnail" >
                                <div class="preview-icon bg-info">
                                    <i class="far fa-envelope mx-0"></i>
                                </div>
                            </div>
                            <div class="preview-item-content">
                                <h6 class="preview-subject font-weight-medium">'.$notif["subject"].'</h6>
                                <p class="font-weight-light small-text">
                                   '.$notif["text"].'
                                </p>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>';
                }
                else{

                    $o = '<li> <a href="#">
                    <strong>'.$notif["subject"].'</strong><br/>
                    <small><em>'.$notif["text"].'</em></small></a></li>';
                }

                array_push($output , $o);
            }
        }
        else{
            if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
                $output = '<a class="dropdown-item">
                            <p class="mb-0 font-weight-normal float-left">No Notification Found
                            </p>
                        </a>';
            }else{
                $output = '<li> <a href="#">
                    <strong>No Notification Found</strong>
                    </a></li>';
            }


        }


        $data = array(
            'notification'   => $output,
            'unseen_notification' => $count
        );
        return new JsonResponse($data);
    }

    function UpdateNotificationJsonAction(Request $request){

        $notifInf = $this->getDoctrine()->getRepository(Notification::class)->findAll();
        foreach ($notifInf as $notif){
            $notif->setStatus(1);
            $em = $this->getDoctrine()->getManager();
            $em->persist($notif);
            $em->flush();
        }
        return new JsonResponse("update");
    }
}