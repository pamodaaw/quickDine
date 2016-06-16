<?php
/**
 * Created by PhpStorm.
 * User: Pamoda
 * Date: 6/11/2016
 * Time: 4:04 PM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\registered_user;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder;

class AdminController extends Controller
{
    /**
     * @Route("admin/addUser", name="add_user")
     */
    public function createRestaurantAction(Request $request)
    {

        $user = new registered_user();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setEmail("pamodaaw@gmail.com");
            $user->setPlainTextpassword($this->randomPassword());
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getplainTextpassword());
            $user->setPassword($password);

            $user->setRole('ROLE_USER');
            $this->save($user);
            $this->sendMailAction($user);
            return $this->redirectToRoute('homepage');
        }
        return $this->render('admin/createRest.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("admin/manageUsers", name="manage_users")
     */
    public function viewUsersAction(Request $request)
    {
        return $this->render('admin/manageUsers.html.twig');
    }

    public function save($user){
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
    }
    private function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public function sendMailAction(registered_user $user)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('Welcome to QuickDine')
            ->setFrom('quickdine.orrs@gmail.com')
            ->setTo($user->getEmail())
            ->setBody("Now you can experience the services of QuickDine. Login to the system and edit your profile \r\n\r\n Username: "
                .$user->getUsername()
                ."\r\n Password:"
                .$user->getplainTextpassword()
                ."\r\n\r\n Thank you for joining with QuickDine." );
        $this->get('mailer')->send($message);
    }

    public function addAdmin(){
        $user= new registered_user();
        $user->setUsername('admin');
        $user->setPlainTextpassword('admin');
        $user->setPassword($this->get('security.password_encoder')
            ->encodePassword($user, $user->getplainTextpassword()));
        $user->setRole('ROLE_ADMIN');
        $this->save($user);
    }

}