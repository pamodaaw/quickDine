<?php
/**
 * Created by PhpStorm.
 * User: Pamoda
 * Date: 6/9/2016
 * Time: 1:11 AM
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\restaurant;
use AppBundle\Entity\registered_user;
use Symfony\Component\HttpFoundation\Session\Session;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="user_login")
     */
    public function loginAction()
    {
        $helper = $this->get('security.authentication_utils');

        //get the login error if there is one
        $error = $helper->getLastAuthenticationError();

        //last username entered by the user
        $lastUsername = $helper->getLastUserName();

        return $this->render('security/login.html.twig', array(

            'last_username' => $lastUsername,
            'error' => $error

        ));
    }

    /**
     * @Route("login/redirect", name="redirect")
     */

    public function redirectAction(){
        $session = new Session();
        $role=$this->getUser()->getRole();
        if ($role=='ROLE_ADMIN'){
            return $this->redirectToRoute('homepage');
        }
        elseif ($role=='ROLE_USER'){
            $user = $this->getUser();
            $userID=$user->getId();
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery('SELECT r FROM AppBundle\Entity\restaurant r  WHERE r.userID =:userID');

            $query->setParameters(array(
                'userID'=>$userID,
            ));
            $restaurant = $query->getResult();

            if(!$restaurant)
                return $this->redirectToRoute('restaurant_create');
            else{

                $this->get('session')->set('loggedRestID', $restaurant[0]->getId());
                return $this->redirectToRoute('restaurant_profile');
            }

        }

    }

    /**
     * This is the route the login form submits to.
     *
     * But, this will never be executed. Symfony will intercept this first
     * and handle the login automatically. See form_login in app/config/security.yml
     *
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {
        throw new \Exception('This should never be reached!');
    }

    /**
     * This is the route the user can use to logout.
     *
     * But, this will never be executed. Symfony will intercept this first
     * and handle the logout automatically. See logout in app/config/security.yml
     *
     * @Route("/logout", name="security_logout")
     */
    public function logoutAction()
    {
        throw new \Exception('This should never be reached!');
    }
    
}

