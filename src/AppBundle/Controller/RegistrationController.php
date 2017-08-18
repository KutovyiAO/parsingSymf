<?php
/**
 * Created by PhpStorm.
 * User: antonkutovoj
 * Date: 17.08.17
 * Time: 03:03
 */
namespace AppBundle\Controller;


use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends Controller
{
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {

        $user = new User();
        $form = $this->createForm($user, UserType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPlainPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('DohrenaKrutoySayt');

        }

        return $this->render('registration/register.html.twig',
            array('form' => $form->createView())
        );

    }
}