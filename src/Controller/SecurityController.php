<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Form\UserType;
use App\Entity\User;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        return new RedirectResponse($this->urlGenerator->generate('prostage_accueil'));
    }

     /**
     * @Route("/inscription", name="app_inscription")
     */
    public function inscrire(Request $request, ObjectManager $entityManager, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        

        $form = $this -> createForm(UserType::class,$user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles(["ROLE_USER"]);

          //Encoder le mot de passe de l'utilisateur
          $encodagePassword = $encoder->encodePassword($user, $user->getPassword());
          $user->setPassword($encodagePassword);
            
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
       }
       return $this->render('security/inscription.html.twig',['form' => $form->createView()]);
    }

    }

