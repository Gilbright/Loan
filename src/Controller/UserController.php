<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    /**
     * @Route("/create_user", name="app_user_create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();

        $form = $this->createForm(UserType::class,$user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($user->getPassword() != $user->getPasswordControl())
            {
                throw new CustomUserMessageAuthenticationException('Password error');
            }

            $em = $this->getDoctrine()->getManager();
            $password = $passwordEncoder->encodePassword($user,$user->getPassword());
            $user->setPassword($password);
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'User Successfully created!');

            return $this->redirectToRoute('app_login');
        }

        return $this->render('user/create_user.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/account", name="app_account")
     * @param AuthenticationUtils $authenticationUtils
     */
    public function show(AuthenticationUtils $authenticationUtils)
    {
        $user = $this->getUser();

        if (! $user)
        {
            throw new CustomUserMessageAuthenticationException('User not found.');
        }

        return $this->render('user/show_user.html.twig',compact('user'));
    }
}
