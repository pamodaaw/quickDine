<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\meal;
use AppBundle\Entity\reservation_meal;    
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\Query\Expr\Join;

class ReservationMealController extends Controller{
    /**
     * @Route("/reservationmeal/create{id}", name="meal_reservation_create")
     */
	public function makeReservation($id, Request $request)
    {

        $reservationMeal = new reservation_meal(); 
        $reservedMeal = $this->getDoctrine()
            ->getRepository('AppBundle:meal')
            ->find($id);
        $reservationMeal->setMealID($reservedMeal);
 		$form = $this->createFormBuilder($reservationMeal)
        ->add('date', DateType::class)
        ->add ('time', TimeType::class)
        ->add('noOfItems', NumberType::class)
        ->add('customerName', TextType::class)
        ->add('email',EmailType::class)
        ->add('contactNumber', NumberType::class )
        ->add('save', SubmitType::class, array('label' => 'Reserve'))
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ) {
            // ... perform some action, such as saving the task to the database
            if($this->checkAvailability($reservedMeal)){
                $this->save($reservationMeal);
                return $this->render('message.html.twig', array(
                    'type' => 'success',
                    'redirect'=> 'meal_viewAll'
                ));
            }
            else
                return $this->render('message.html.twig', array(
                    'type' => 'failure',
                    'redirect'=> 'meal_reservation_create',
                    'id'=> $id,
                ));

        }
        return $this->render('reservationMeal/create.html.twig', array(
            'form' => $form->createView(),));
        
    }

    /**
     * @Route("user/reservationmeal/confirm{id}", name="meal_reservation_confirm")
     */
    public function confirmAction($id){
        $em = $this->getDoctrine()->getManager();
        $reservation = $em->getRepository('AppBundle:reservation_meal')->find($id);

        if (!$reservation) {
            return $this->render('message.html.twig', array(
                'type' => 'notfound'
            ));
        }

        $reservation->setConfirmation(True);
        $em->flush();
        return $this->redirectToRoute('reservation_meal_viewAll');
    }

    /**
     * @Route("user/reservationMeal/view", name="reservation_meal_viewAll")
     */
    public function viewAllAction(Request $request)
    {
        $id= $this->get('session')->get('loggedRestID');
        $repository = $this->getDoctrine()
            ->getRepository('AppBundle:reservation_meal');
        $qb = $repository->createQueryBuilder('r')
            ->innerJoin('r.mealID', 'm', 'WITH', 'r.mealID = m.id')
            ->where('m.restID = :id')
            ->setParameter('id', $id)
            ->getQuery();

        $reservations = $qb->getResult();
      
        if(!$reservations){
            return $this->render('message.html.twig', array(
                'type' => 'notfound'
            ));
        }

        
        return $this->render('reservationMeal/viewAll.html.twig', array('reservations' => $reservations));  

    }

    public function save($reservationMeal){
         $em = $this->getDoctrine()->getManager();
         $em->persist($reservationMeal);
         $em->flush();
    }

    public function checkAvailability($meal){
        if ($meal->getAvailability())
            return True;
        else return False;
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

}