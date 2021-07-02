<?php

namespace App\Controller;

use App\Service\UserHandler;
use App\Form\BilleterieFormType;
use App\Repository\UserRepository;
use App\Service\BilletterieHandler;
use App\Repository\ArtistRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
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

        return $this->render('billeterie/agenda.html.twig', [
            'agenda' => $agenda,
            'artists' => $artists,
        ]);
    }


    /**
     * @Route("/billeterie", name="billeterie_form")
     */
    public function billeterie(BilletterieHandler $billetterieHandler, UserInterface $user,  UserHandler $userHandler, Request $request, \Swift_Mailer $mailer, ArtistRepository $artistRepository): Response
    {
        if($this->getUser() == null){
            $this->addFlash('billeterie_register', 'Vous devez vous enregistrer pour reserver un billet, merci de vous enregistrer ou de vous connecter !');
            
            return $this->redirectToRoute('home');
        }

        $agenda = [
            'dates' => ['20/08/2021', '21/08/2021', '22/08/2021'],
            'plages' => ['16h - 18h', '18h - 20h', '21h - 23h'],
        ];

        $artists = $artistRepository->findArtitsInConcert();

        $form = $this->createForm(BilleterieFormType::class);

        $i = 0;
        foreach($agenda['dates'] as $date){
            foreach($agenda['plages'] as $plage){
                $form->add('nbTickets_'.str_replace(" ", "", $artists[$i]->getName()), IntegerType::class, [
                    'label' => $artists[$i]->getName().' - '.$date.' - '.$plage,
                    'attr' => ($request->get('nbPlace') && ($request->get('artist')==$artists[$i]->getName())) ? ['value' => $request->get('nbPlace'), 'min' => '0'] : ['value' => '0', 'min' => '0'],
                    ]
                    );
                $i++;
            }
        }

        $form->add('Envoyer', SubmitType::class, [
            'attr' => [
                'class' => 'mb-3 mt-3 btn btn-lg btn-primary'
            ],
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $dataForm = $form->getData();
            
            $dataFormFiltered = [];
            foreach($dataForm as $key => $value) {
                if($value != '0'){
                    $dataFormFiltered[$key] = $value;
                }
                
            }
            
            $mailBody = $this->renderView('email/reservation.html.twig', [
                        'dataForm' => $dataFormFiltered,
            ]);

            $billetterieHandler->mailer('Festival Technonite Demande de Reservation', 'festival_reservation@festival.com', $mailBody, $user, $mailer);

            $this->addFlash('reservation_sent', 'Votre demande de reservation a bien été envoyé aux organisateurs, vous receverez une confirmation prochainement.');
            
            return $this->redirectToRoute('home');
        }
        

        return $this->render('billeterie/form.html.twig', [
            'BilleterieForm' => $form->createView(),
            'artists' => $artists,
        ]);

    }

}
