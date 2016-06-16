<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\reservation_rest;    

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormError;

class ReservationRestController extends Controller{
    /**
     * @Route("/reservationRest/create{id}", name="rest_reservation_create")
     */
	public function makeReservation($id, Request $request)
    {

        $reservationRest = new reservation_rest(); 
        $reservedRest = $this->getDoctrine()
            ->getRepository('AppBundle:restaurant')
            ->find($id);
        $reservationRest->setRestID($reservedRest);
 		$form = $this->createFormBuilder($reservationRest)
        ->add('date', DateType::class)
        ->add ('startTime', TimeType::class)
        ->add('noOfPeople', NumberType::class)
        ->add ('expectedHours', NumberType::class)
        ->add('customerName', TextType::class)
        ->add('email',EmailType::class)
        ->add('contactNumber', NumberType::class)
        ->add('save', SubmitType::class, array('label' => 'Reserve'))
        ->getForm();

        $form->handleRequest($request);


if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database
            $this->setEndTime($reservationRest);
            if($this->checkAvailability($reservationRest)){

                $this->save($reservationRest);
                $this->sendMailAction($reservedRest,$reservationRest);
                return $this->render('message.html.twig', array(
                    'type' => 'success',
                    'redirect'=> 'restaurant_viewAll'
                ));
            }
            else
                return $this->render('message.html.twig', array(
                    'type' => 'failure',
                    'redirect'=> 'rest_reservation_create',
                    'id'=> $id,
                ));
        }

            return $this->render('reservationRest/create.html.twig', array('form' => $form->createView(),));
       
    }

    /**
     * @Route("user/reservationRest/confirm{id}", name="rest_reservation_confirm")
     */
    public function confirmAction($id){
        $em = $this->getDoctrine()->getManager();
        $reservation = $em->getRepository('AppBundle:reservation_rest')->find($id);

        if (!$reservation) {
            return $this->render('message.html.twig', array(
                'type' => 'notfound'
            ));
        }

        $reservation->setConfirmation(True);
        $em->flush();
        return $this->redirectToRoute('reservation_rest_viewAll');
    }

    /**
     * @Route("user/reservationRest/view", name="reservation_rest_viewAll")
     */
    public function viewAllAction(Request $request)
    {
        $id= $this->get('session')->get('loggedRestID');
        $reservations = $this->getDoctrine()
            ->getRepository('AppBundle:reservation_rest')
            ->findBy(array('restID' => $id));
        if(!$reservations){
            return $this->render('message.html.twig', array(
                'type' => 'notfound'
            ));
        }
        return $this->render('reservationRest/viewAll.html.twig', array('reservations' => $reservations));  

    }
    public function save($reservationRest){
         $em = $this->getDoctrine()->getManager();
         $em->persist($reservationRest);
         $em->flush();
    }

    public function sendMailAction($reservedRest,$reservationRest)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('Online Reservation')
            ->setFrom('quickdine.orrs@gmail.com')
            ->setTo($reservedRest->getEmail())
            ->setBody("An online reservation is made. Please login to QuickDine and check the reservation");
        $this->get('mailer')->send($message);
    }

    /**
     * @param $reservation
     */
    public function setEndTime(reservation_rest $reservation){

        $end_time = $reservation->getStartTime();
        date_add($end_time, date_interval_create_from_date_string($reservation->getExpectedHours()+'hours'));
        $reservation->setEndTime($end_time);
    }
    
    public function  checkAvailability(reservation_rest $reservation){
        $em = $this->getDoctrine()->getManager();
        $restID= $reservation->getRestID();
        $date= $reservation->getDate();
        $startTime = $reservation->getStartTime();
        $endTime = $reservation->getEndTime();
        $query = $em->createQuery('SELECT r FROM AppBundle\Entity\reservation_rest r WHERE r.restID = :restID AND r.date = :date AND 
            ((r.startTime < :startTime AND r.endTime > :endTime ) OR (r.startTime > :startTime OR r.endTime <= :endTime ))');

        $query->setParameters(array(
            'restID'=>$restID,
            'date' => $date,
            'startTime' => $startTime,
            'endTime' => $endTime,
        ));
        $reservations = $query->getResult();
        $allocated=$reservation->getNoOfPeople();
        foreach ($reservations as $r){
            $allocated += $r->getNoOfPeople();
        }
        if ($allocated>$reservation->getRestID()->getCapacity()){
            return false;
        }
        else return true;
    }


}