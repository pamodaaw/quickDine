<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\offer;  

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormError;

class OfferController extends Controller
{
    /**
     * @Route("/offer/", name = "offer_home")
     */
    public function indexAction(Request $request)
    {
        return $this->redirectToRoute('offer_viewAll');
    }

    /**
     * @Route("user/offer/create", name="offer_create")
     */
    public function createAction(Request $request)
    {

        $offer = new offer();
        $id= $this->get('session')->get('loggedRestID');
        $rest = $this->getDoctrine()
            ->getRepository('AppBundle:restaurant')
            ->find($id);
        $offer->setRestID($rest);
        $form = $this->createFormBuilder($offer)
        ->add('description', TextType::class)
        ->add('available', TextType::class)
        ->add('catchLine', TextType::class)
        ->add('image_path', FileType::class, array('label'=> 'Image',))
        ->add('save', SubmitType::class, array('label' => 'Add'))
        ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            
            $this->save($offer);
            return $this->redirectToRoute('offer_viewAllByRest');

        }
        return $this->render('offer/create.html.twig', array(
            'form' => $form->createView(),));
        
    }
    /**
     * @Route("/offer/view/{id}/update", name="offer_update")
     */
    public function updateAction($id,Request $request)
    {
        $offer = $this->getDoctrine()
            ->getRepository('AppBundle:offer')
            ->find($id);
        $form = $this->createFormBuilder($offer)
            ->add('description', TextType::class)
            ->add('available', TextType::class)
            ->add('catchLine', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Update'))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            $this->save($offer);
            return $this->redirectToRoute('offer_viewAllByRest');

        }
        return $this->render('offer/update.html.twig', array(
            'form' => $form->createView(),));
    }

    /**
     * @Route("/offer/view/{id}", name="offer_view")
     */
    public function viewAction($id, Request $request)
    {
        $offer = $this->getDoctrine()
            ->getRepository('AppBundle:offer')
            ->find($id);
      
        if(!$offer){
            throw $this->createNotFoundException(
                'Object not found');
            
        }
       
        return $this->render('offer/viewall.html.twig', array('offers' => $offer));  

    }

    /**
     * @Route("/offer/view", name="offer_viewAll")
     */
    public function viewallAction( Request $request)
    {

        $offers = $this->getDoctrine()
            ->getRepository('AppBundle:offer')
            ->findAll();

    return $this->render('offer/viewall.html.twig', array('offers' => $offers));

    }

    /**
     * @Route("/offer/viewAllByRest", name="offer_viewAllByRest")
     */
    public function rest_viewallAction(Request $request)
    {
        $id= $this->get('session')->get('loggedRestID');
        $offers = $this->getDoctrine()
            ->getRepository('AppBundle:offer')
            ->findBy(array ('restID' => $id));

    return $this->render('offer/viewall.html.twig', array('offers' => $offers));

    }
    /**
     * @Route("/offer/viewByRest{id}", name="offersByRest")
     */
    public function viewByRestAction($id,Request $request)
    {
        $offers = $this->getDoctrine()
            ->getRepository('AppBundle:offer')
            ->findBy(array ('restID' => $id));

        return $this->render('offer/viewall.html.twig', array('offers' => $offers));

    }

   /**
     * getRestNameByID
     *
     * @param integer $id
     *
     * @return string
     */

    public function getRestNameByID($id)
    {
        $restaurant = $this->getDoctrine()
            ->getRepository('AppBundle:restaurant')
            ->find($id);
        $rest_name= $restaurant->getName();
        return $rest_name;
    }

    public function save($offer){
         $em = $this->getDoctrine()->getManager();
         $em->persist($offer);
         $em->flush();
    }

}



