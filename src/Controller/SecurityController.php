<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
/**
 * @Route("/security")
 */
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
        //throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
        return $this->redirectToRoute("accueil");
    }

    /**
     * @Route("/admin",name="a")
     */
    public function welcomeAdmin(){
       return  $this->render("security/welcomeAdmin.html.twig");
    }

    /**
     * @Route("/enqueteur",name="enqueteur")
     */
    public function welcomeEnqueteur(){
        return  $this->render("security/welcomeEnqueteur.html.twig");
    }

    /**
     * @Route("/sonde",name="s")
     */
    public function welcomesonde(){
        return $this->render("security/welcomesonde.html.twig");
    }

    /**
     * @Route("/consultant",name="c")
     */
    public function welcomeConsultant(){
        return $this->render("security/welcomeConsultant.html.twig");
    }
}
