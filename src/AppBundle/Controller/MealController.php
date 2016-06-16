<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\meal;  
use AppBundle\Entity\cuisine;  

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormError;

class MealController extends Controller
{
    /**
     * @Route("/meal/", name = "meal_home")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->redirectToRoute('meal_viewAll');
    }
    /**
     * @Route("user/meal/create", name="meal_create")
     */
    public function createAction(Request $request)
    {

        $meal = new meal();
        $userID=$this->getUser()->getId();
        $rest = $this->getDoctrine()
            ->getRepository('AppBundle:restaurant')
            ->findOneBy(array('userID'=>$userID));
        $meal->setRestID($rest);
        $form = $this->createFormBuilder($meal)
        ->add('code', TextType::class)
        ->add ('description', TextType::class)
        ->add('name', TextType::class)
        ->add('cost_for_two', TextType::class)
        ->add('cuisineID', EntityType::class, array('class' => 'AppBundle:cuisine','choice_label' => 'name', 'label' => 'Cuisine',))
        ->add('availability', ChoiceType::class, array('choices'=> array('available' => True, 'unavailable' => False ),
            'multiple' => false,
            'expanded' => true,
            'required' => true,) )
        ->add('path', FileType::class, array('label'=> 'Image',))
        ->add('save', SubmitType::class, array('label' => 'Create'))
        ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->save($meal);
            return $this->redirectToRoute('meal_viewAllByRest');

        }
        return $this->render('meal/create.html.twig', array(
            'form' => $form->createView(),));
        
    }
    /**
     * @Route("user/meal/view/{id}/update", name="meal_update")
     */
    public function updateAction($id,Request $request)
    {

        $meal = $this->getDoctrine()
            ->getRepository('AppBundle:meal')
            ->find($id);
        $form = $this->createFormBuilder($meal)
            ->add('code', TextType::class)
            ->add ('description', TextType::class)
            ->add('name', TextType::class)
            ->add('cost_for_two', TextType::class)
            ->add('cuisineID', EntityType::class, array('class' => 'AppBundle:cuisine','choice_label' => 'name', 'label' => 'Cuisine',))
            ->add('availability', ChoiceType::class, array('choices'=> array('available' => True, 'unavailable' => False ),
                'multiple' => false,
                'expanded' => true,
                'required' => true,) )
            ->add('save', SubmitType::class, array('label' => 'Update'))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->save($meal);
            return $this->redirectToRoute('meal_viewAllByRest');

        }
        return $this->render('meal/create.html.twig', array(
            'form' => $form->createView(),));
        
    }

    /**
     * @Route("/meal/view/{id}", name="meal_view")
     */
    public function viewAction($id, Request $request)
    {
        $meal = $this->getDoctrine()
            ->getRepository('AppBundle:meal')
            ->find($id);
      
        if(!$meal){
            throw $this->createNotFoundException(
                'Object not found');
            
        }

        
        return $this->render('meal/view.html.twig', array('meal' => $meal));  

    }

    /**
     * @Route("/meal/view", name="meal_viewAll")
     */
    public function viewallAction( Request $request)
    {

        $meals = $this->getDoctrine()
            ->getRepository('AppBundle:meal')
            ->findAll();

    return $this->render('meal/viewall.html.twig', array('meal' => $meals));

    }

    /**
     * @Route("/meal/viewAllByRest", name="meal_viewAllByRest")
     */
    public function viewALLByRestAction(Request $request)
    {

        $id= $this->get('session')->get('loggedRestID');
        $meals = $this->getDoctrine()
            ->getRepository('AppBundle:meal')
            ->findBy(array ('restID' => $id));

    return $this->render('meal/viewall.html.twig', array('meal' => $meals));
    }

    /**
     * @Route("/meal/viewAllByRest{id}", name="mealsByRest")
     */
    public function viewByRestAction($id,Request $request)
    {
        $meals = $this->getDoctrine()
            ->getRepository('AppBundle:meal')
            ->findBy(array ('restID' => $id));

        return $this->render('meal/viewall.html.twig', array('meal' => $meals));
    }

    public function save($meal){
         $em = $this->getDoctrine()->getManager();
         $em->persist($meal);
         $em->flush();
    }

}



