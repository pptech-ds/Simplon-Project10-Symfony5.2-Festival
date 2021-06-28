<?php

namespace App\Controller;

use App\Form\BilleterieFormType;
use App\Service\UserHandler;
use App\Repository\UserRepository;
use App\Repository\ArtistRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BilleterieController extends AbstractController
{
    /**
     * @Route("/agenda", name="billeterie_agenda")
     */
    public function agenda(ArtistRepository $artistRepository): Response
    {
        $agenda = [
            'dates' => ['20/08/2021', '21/08/2021', '22/08/2021'],
            'plages' => ['16h - 18h', '18h - 20h', '21h - 23h'],
        ];

        $artists = $artistRepository->findArtitsInConcert();

        // dd($artists);
        // dd($table);

        return $this->render('billeterie/agenda.html.twig', [
            'agenda' => $agenda,
            'artists' => $artists,
        ]);
    }


    /**
     * @Route("/billeterie", name="billeterie_form")
     */
    public function billeterie(UserHandler $userHandler, Request $request, \Swift_Mailer $mailer, ArtistRepository $artistRepository): Response
    {
        // dd($this->getUser());

        if($this->getUser() == null){
            $this->addFlash('billeterie_register', 'Vous devez vous enregistrer pour reserver un billet, merci de vous enregistrer ou de vous connecter !');
            
            return $this->redirectToRoute('home');
        }

        $artists = $artistRepository->findArtitsInConcert();

        $form = $this->createForm(BilleterieFormType::class);
        $form->handleRequest($request);

        
        
        if ($form->isSubmitted() && $form->isValid()) {

            // dd('OK');

            $dataForm = $form->getData();
            // $BilleterieForm = $request->get('BilleterieForm');
            // $postData = $request->request->get('contact');

            // dd($dataForm, $form->get('email')->getData());

            $message = new \Swift_Message('Festival Technonite Demande de Reservation');
            $message->setFrom($form->get('email')->getData());
            $message->setTo('festival_reservation@festival.com');
            $message->setBody(
                $this->renderView('email/reservation.html.twig', [
                    'dataForm' => $dataForm,
                ]),
                'text/html'
            );

            $mailer->send($message);

            // $logger->info('email sent');
            $this->addFlash('reservation_sent', 'Votre demande de reservation a bien été envoyé aux organisateurs, vous receverez une confirmation prochainement.');
            
            return $this->redirectToRoute('home');
        }
        else{
            if($userHandler->getUserInfos() != null){
                $form->get('email')->setData($userHandler->getUserInfos()->getEmail());
            }
    
            if($request->get('date') != null){
                $form->get('date')->setData($request->get('date'));
            }
    
            if($request->get('plage') != null){
                $form->get('plage')->setData($request->get('plage'));
            }
    
            if($request->get('artist') != null){
                $form->get('artist')->setData($request->get('artist'));
            }
        }

        return $this->render('billeterie/form.html.twig', [
            'BilleterieForm' => $form->createView(),
            'artists' => $artists,
        ]);

    }

}
