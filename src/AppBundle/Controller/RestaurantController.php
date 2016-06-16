<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\restaurant;    

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormError;

class RestaurantController extends Controller
{
    /**
     * @Route("/restaurant/", name="restaurant_home")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->redirectToRoute('restaurant_viewAll');
    }


    /**
     * @Route("/restaurant/create", name="restaurant_create")
     */
    public function createAction(Request $request)
    {
        {

            $restaurant = new restaurant();
            $user=$this->getUser();
            $restaurant->setUserID($user);
            $restaurant->setLocLat(234);
            $restaurant->setLocLog(2344);
            $form = $this->createFormBuilder($restaurant)
                ->add('name', TextType::class)
                ->add('websiteUrl', UrlType::class)
                ->add('capacity', NumberType::class)
                ->add('location', TextType::class)
                ->add('costForTwo',NumberType::class)
                ->add('email',EmailType::class)
                ->add('contactNumber', NumberType::class)
                ->add('description', TextType::class)
                ->add('activate', ChoiceType::class, array('choices'=> array('activate' => True, 'deactivate' => False ),
                    'multiple' => false,
                    'expanded' => true,
                    'required' => true,) )
                ->add('save', SubmitType::class, array('label' => 'Create'))
                ->getForm();

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->save($restaurant);

            }

            return $this->render('restaurant/create.html.twig', array('form' => $form->createView(),));

        }
        
    }

    /**
     * @Route("user/restaurant/view/{id}/update", name="update_details")
     */
    public function updateAction($id,Request $request)
    {
        $restaurant = $this->getDoctrine()
            ->getRepository('AppBundle:restaurant')
            ->find($id);
        $form = $this->createFormBuilder($restaurant)
            ->add('name', TextType::class)
            ->add('websiteUrl', UrlType::class)
            ->add('capacity', NumberType::class)
            ->add('location', TextType::class)
            ->add('costForTwo',NumberType::class)
            ->add('email',EmailType::class)
            ->add('contactNumber', NumberType::class)
            ->add('description', TextType::class)
            ->add('activate', ChoiceType::class, array('choices'=> array('activate' => True, 'deactivate' => False ),
                'multiple' => false,
                'expanded' => true,
                'required' => true,) )
            ->add('save', SubmitType::class, array('label' => 'Update'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->save($restaurant);
        }

        return $this->render('restaurant/create.html.twig', array('form' => $form->createView(),));

    }
    /**
     * @Route("/restaurant/viewProfile", name="restaurant_profile")
     */
    public function viewProfileAction(Request $request)
    {
        $id= $this->get('session')->get('loggedRestID');
        $restaurant = $this->getDoctrine()
            ->getRepository('AppBundle:restaurant')
            ->findOneBy(array('userID'=> $id));
        if(!$restaurant){
            throw $this->createNotFoundException(
                'Object not found');
        }
        return $this->render('restaurant/viewProfile.html.twig', array('restaurant' => $restaurant));
    }

    /**
     * @Route("/restaurant/view{id}", name="restaurant_view")
     */
    public function viewAction($id, Request $request)
    {
        $restaurant = $this->getDoctrine()
            ->getRepository('AppBundle:restaurant')
            ->find($id);
      
        if(!$restaurant){
            throw $this->createNotFoundException(
                'Object not found');
            
        }
        return $this->render('restaurant/view.html.twig', array('restaurant' => $restaurant));  

    }

    /**
     * @Route("/restaurant/view", name="restaurant_viewAll")
     */
    public function viewallAction( Request $request)
    {
        $restaurants = $this->getDoctrine()
            ->getRepository('AppBundle:restaurant')
            ->findAll();

        return $this->render('restaurant/viewall.html.twig', array('restaurants' => $restaurants));

    }

    /**
     * @Route("/restaurant/rate{id}", name="restaurant_rate1")
     */
    public function rate1Action(){
        $em = $this->getDoctrine()->getManager();
        $restaurant = $em->getRepository('AppBundle:restaurant')
            ->find($id);

        if (!$restaurant) {
            throw $this->createNotFoundException(
                'No restaurant is found for id '.$id
            );
        }

        $rate= ($restaurant->getRating()+1)/100;
        $em->flush();

        return $this->redirectToRoute('reservation_rest_viewAll');
    }

    public function save($restaurant){
        $em = $this->getDoctrine()->getManager();
        $em->persist($restaurant);
        $em->flush();
}



}



