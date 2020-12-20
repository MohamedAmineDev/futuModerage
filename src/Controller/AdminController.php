<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Form\AdminType;
use App\Form\AdminUpdateType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }


    /**
     * @Route("/inscriptionAdmin",name="addAdmin")
     */
    public function addAdmin(UserPasswordEncoderInterface $encoder,Request $req){

        $admin=new User();
        $form = $this->createForm(AdminType::class, $admin);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $encoded = $encoder->encodePassword($admin, $admin->getPassword());
            $manager = $this->getDoctrine()->getManager();
            $admin->setRoles(["Admin"]);
            $admin->setPassword($encoded);
            $manager->persist($admin);
            $manager->flush();
        }
            return $this->render('admin/inscription.html.twig', [
                'form' => $form->createView()
                
            ]);
    }

    /**
     * @Route("accueilAdmin",name="accueilAdmin")
     */
    public function homeAdmin(){
        return $this->render("admin/home.html.twig");
    }




    
    /**
     * @Route("/updateAdmin",name="updateAdmin")
     */
    public function updateAdmin(UserPasswordEncoderInterface $encoder,Request $req){
        $enqueteur=$this->getUser();
        $form = $this->createForm(AdminUpdateType::class, $enqueteur);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $encoded = $encoder->encodePassword($enqueteur, $enqueteur->getPassword());
            $enqueteur->setPassword($encoded);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('updateEnqueteur');
        }
        

        return $this->render('admin/update.html.twig', [
            'enqueteur' => $enqueteur,
            'form' => $form->createView(),
        ]);
    }
}
