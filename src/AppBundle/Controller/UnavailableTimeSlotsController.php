<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\meal_unavailable;  
use AppBundle\Entity\cuisine;  

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormError;

class UnavailableTimeSlotsController extends Controller
{

    /**
     * @Route("/meal/view/{id}/add_unavailability", name="add_unavailability")
     */
    public function createAction($id, Request $request)
    {

        $unavailability = new meal_unavailable();
        $meal = $this->getDoctrine()
            ->getRepository('AppBundle:meal')
            ->find($id);
        $unavailability->setMealID($meal);
        $form = $this->createFormBuilder($unavailability)
        ->add('day', 'choice', array(
        'choices' => array(
          'Sunday' => 'sunday',
          'Monday' => 'monday'
        ),
        'multiple' => false,
        'expanded' => true,
        'required' => true,
        'data'     => 'male'
    ))
        ->add('save', SubmitType::class, array('label' => 'Create'))
        ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->save($unavailability);
            return $this->redirectToRoute('meal_view', array('id' => $meal->getId()));

        }
        return $this->render('meal/unavailability.html.twig', array(
            'form' => $form->createView(),));
        
    }


    public function save($unavailability){
         $em = $this->getDoctrine()->getManager();
         $em->persist($unavailability);
         $em->flush();
    }

}



