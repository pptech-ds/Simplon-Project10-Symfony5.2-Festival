<?php

namespace App\Controller;

use App\Service\UserHandler;
use App\Form\BilleterieFormType;
use App\Repository\UserRepository;
use App\Repository\ArtistRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
        
        $artists_array = [];
        foreach($artists as $artist){
            $artists_array[$artist->getName()] = $artist->getName();
        }
        // dd($artists_array);

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
                // $form->get('date')->setData($request->get('date'));
                $form->add('date', ChoiceType::class, [
                    'label' => 'Date',
                    'choices'  => [$request->get('date') => $request->get('date')]
                    ]);
            }
            else{
                $form->add('date', ChoiceType::class, [
                    'label' => 'Date',
                    'choices'  => [
                        '20/08/2021' => '20/08/2021',
                        '21/08/2021' => '21/08/2021',
                        '22/08/2021' => '22/08/2021',
                    ]
                    ]);
            }
    
            if($request->get('plage') != null){
                // $form->get('plage')->setData($request->get('plage'));
                $form->add('plage', ChoiceType::class, [
                    'label' => 'Plage',
                    'choices'  => [$request->get('plage') => $request->get('plage')]
                    ]);
            }
            else{
                $form->add('plage', ChoiceType::class, [
                    'label' => 'Plage',
                    'choices'  => [
                        '16h - 18h' => '16h - 18h',
                        '18h - 20h' => '18h - 20h',
                        '21h - 23h' => '21h - 23h',
                        ]
                    ]);
            }
    
            if($request->get('artist') != null){
                $form->add('artist', ChoiceType::class, [
                    'label' => 'Artiste',
                    'choices'  => [$request->get('artist') => $request->get('artist')]
                    ]);
            }
            else{
                $form->add('artist', ChoiceType::class, [
                    'label' => 'Artiste',
                    'choices'  => $artists_array
                    ]);
            }
        }

        return $this->render('billeterie/form.html.twig', [
            'BilleterieForm' => $form->createView(),
            'artists' => $artists,
        ]);

    }

}
