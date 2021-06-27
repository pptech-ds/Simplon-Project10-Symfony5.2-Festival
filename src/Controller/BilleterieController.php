<?php

namespace App\Controller;

use App\Form\BilleterieType;
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
    public function billeterie(UserHandler $userHandler, Request $request, \Swift_Mailer $mailer): Response
    {
        $user = $userHandler->getUserInfos();
        $date = $request->get("date");
        $plage = $request->get("plage");
        $userEmail = $user->getEmail();
        $artist = $request->get("artist");
        // dd($date, $plage, $userEmail);

        $form = $this->createForm(BilleterieType::class);
        $form->handleRequest($request);

        
        
        if ($form->isSubmitted() && $form->isValid()) {

            // dd('OK');

            $dataForm = $form->getData();
            // $BilleterieForm = $request->get('BilleterieForm');
            // $postData = $request->request->get('contact');

            // dd($dataForm);

            $message = new \Swift_Message('Festival Technonite Demande de Reservation');
            $message->setFrom($userEmail);
            $message->setTo('festival_reservation@festival.com');
            $message->setBody(
                $this->renderView('email/reservation.html.twig', [
                    'dataForm' => $dataForm,
                ]),
                'text/html'
            );

            $mailer->send($message);

            // $logger->info('email sent');
            $this->addFlash('notice', 'Email sent');
            
            return $this->redirectToRoute('home');
        }
        else{
            if($userEmail != null){
                $form->get('email')->setData($userEmail);
            }
    
            if($date != null){
                $form->get('date')->setData($date);
            }
    
            if($plage != null){
                $form->get('time')->setData($plage);
            }
    
            if($plage != null){
                $form->get('artist')->setData($artist);
            }
        }

        return $this->render('billeterie/form.html.twig', [
            'BilleterieForm' => $form->createView(),
        ]);

    }

}
