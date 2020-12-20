<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Conversation;
use App\Repository\MessagesRepository;
use App\Repository\ConversationRepository;
use App\Form\ConversationType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Messages;
use App\Form\MessageType;



class ChatController extends AbstractController
{
    /**
     * @Route("/chat", name="chat")
     */
    public function index(): Response
    {
        return $this->render('chat/index.html.twig', [
            'controller_name' => 'ChatController',
        ]);
    }


    /**
     * @Route("/new/conversation",name="addConversation")
     */
    public function createConversation(Request $req){
        $conversation=new Conversation();
        $form = $this->createForm(ConversationType::class, $conversation);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($conversation);
            $manager->flush();
        }
            return $this->render('chat/createConversation.html.twig', [
                'form' => $form->createView()
                
            ]);
    }
    /**
     * @Route("listeConversation",name="conversation")
     */
    public function conversations(){
        $conversations=$this->getUser()->getConversation();
        return $this->render("conversation/list.html.twig");
    }

    /**
     * @Route("new/message/{id}",name="addMessage")
     */
    public function addMessage(Request $req,Conversation $id){
        $messages=$id->getMessages();
        $message=new Messages();
        $user=$this->getUser();
        $message-> setUser($user);
        $message->setConversation($id);
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($message);
            $manager->flush();
            return $this->redirectToRoute('addMessage',['id'=>$id->getId()]);
        }
            return $this->render('chat/list.html.twig', [
                'form' => $form->createView(),'chat'=>$messages
                
            ]);
    }
}
