<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Sondage;
use Symfony\Component\HttpFoundation\JsonResponse;

class StatisticController extends AbstractController
{
    /**
     * @Route("/statistic", name="statistic")
     */
    public function index(): Response
    {
        return $this->render('statistic/index.html.twig', [
            'controller_name' => 'StatisticController',
        ]);
    }

    /**
    *@Route("/statisticReponse/{id}/display",name="calcule",methods={"POST"})
    */
    public function calcule(Sondage $sondage){
        //$user=$this->getUser();
        //$sondages=$user-> getSondages();
        $questions=$sondage->getQuestions();
        $i=0;
        $res=array();
        $l=count($questions);
        while($i<$l){
            $choix=$questions[$i]->getOptions();
            $reponses=$questions[$i]->getReponses();
            $stat=array();
            if($choix!= null && $reponses!=null){
                $j=0;
                while($j<count($choix)){
                    $k=0;
                    $tab=$reponses;
                    $ch=$choix[$j];
                    $cpt=0;
                    while ($k<count($tab)) {
                        if($tab[$k]->getText()==$ch->getContenue()){
                            $cpt++;
                        }
                        $k++;
                    }
                    $t=array("$ch"=>$cpt);
                    array_push ($res,$t);
                    $j++;
                }
            }
            $i++;
        }
        // TODO 
        return new JsonResponse(['stat'=>$res,'id'=>$sondage->getId()]);
        
    }
}
