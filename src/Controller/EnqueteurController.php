<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Form\EnqueteurType;
use App\Form\EnqueteurUpdateType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
/**
 * @Route("/enqueteur")
 */
class EnqueteurController extends AbstractController
{
    


    /**
     * @Route("/inscription",name="addEnqueteur")
     */
    public function addEnqueteur(UserPasswordEncoderInterface $encoder,Request $req){

        $admin=new User();
        $form = $this->createForm(EnqueteurType::class, $admin);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $encoded = $encoder->encodePassword($admin, $admin->getPassword());
            $manager = $this->getDoctrine()->getManager();
            $admin->setRoles(["Enqueteur"]);
            $admin->setPassword($encoded);
            $manager->persist($admin);
            $manager->flush();
            return $this->redirectToRoute('accueil');
        }
            return $this->render('enqueteur/inscription.html.twig', [
                'form' => $form->createView()
                
            ]);
    }

     /**
     * @Route("/accueilEnqueteur", name="accueilEnqueteur")
     */
    public function accueilEnqueteur(): Response
    {
        return $this->render('Enqueteur\accueil_enqueteur.html.twig');
    }


    /**
     * @Route("sondage/reponse",name="reponses")
     */
    public function consulterReponse(){
        if($this->getUser()){
            $user = $this->getUser();
        $sondages=$user->getSondages();
       return $this->render("sonde/mesSondage.html.twig",['sondages'=>$sondages]);
        }
        else{
            //echo "<script>alert('vous devez vous connecter dabord')</script>";
            return $this->redirectToRoute('app_login');
        }
    }


    /**
 * @Route("update/enqueteur",name="updateEnqueteur")
 */
public function updateEnqueteur(Request $req,UserPasswordEncoderInterface $encoder){
    $enqueteur=$this->getUser();
    $form = $this->createForm(EnqueteurUpdateType::class, $enqueteur);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $encoded = $encoder->encodePassword($enqueteur, $enqueteur->getPassword());
            $enqueteur->setPassword($encoded);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('accueilEnqueteur');
        }
        

        return $this->render('Enqueteur/edit.html.twig', [
            'enqueteur' => $enqueteur,
            'form' => $form->createView(),
        ]);
    }
}
