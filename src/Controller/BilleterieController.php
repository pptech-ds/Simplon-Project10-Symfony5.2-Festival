<?php

namespace App\Controller;

use App\Service\UserHandler;
use App\Form\BilleterieFormType;
use App\Repository\UserRepository;
use App\Repository\ArtistRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
    public function billeterie( UserInterface $user,  UserHandler $userHandler, Request $request, \Swift_Mailer $mailer, ArtistRepository $artistRepository): Response
    {
        // dd($this->getUser());

        // dd($user->getEmail());

        if($this->getUser() == null){
            $this->addFlash('billeterie_register', 'Vous devez vous enregistrer pour reserver un billet, merci de vous enregistrer ou de vous connecter !');
            
            return $this->redirectToRoute('home');
        }

        $agenda = [
            'dates' => ['20/08/2021', '21/08/2021', '22/08/2021'],
            'plages' => ['16h - 18h', '18h - 20h', '21h - 23h'],
        ];

        $artists = $artistRepository->findArtitsInConcert();
        
        // $artists_array = [];
        // foreach($artists as $artist){
        //     $artists_array[$artist->getName()] = $artist->getName();
        // }
        // dd($artists_array);

        $form = $this->createForm(BilleterieFormType::class);

        $i = 0;
        foreach($agenda['dates'] as $date){
            foreach($agenda['plages'] as $plage){
                $form->add('nbTickets_'.str_replace(" ", "", $artists[$i]->getName()), IntegerType::class, [
                    'label' => $artists[$i]->getName().' - '.$date.' - '.$plage,
                    'attr' => ['value' => '1', 'min' => '0'],
                    ]
                    );
                $i++;
            }
        }

        // ->add('Artiste', EntityType::class, [
        //     'class' => Artist::class,
        //     'label' => 'Artiste',
        //     'multiple' => true,
        //     'mapped' => false,
        //     'required' => false,
        //     'expanded' => true,
        // ])


        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $dataForm = $form->getData();

            // dd($dataForm);

            $dataFormFiltered = [];

            foreach($dataForm as $key => $value) {
                if($value != '0'){
                    $dataFormFiltered[$key] = $value;
                }
                
            }
            
            // dd($dataForm, $dataFormFiltered);

            // $mail->send()


            $message = new \Swift_Message('Festival Technonite Demande de Reservation');
            $message->setFrom($user->getEmail());
            $message->setTo('festival_reservation@festival.com');
            $message->setBody(
                $this->renderView('email/reservation.html.twig', [
                    'dataForm' => $dataFormFiltered,
                ]),
                'text/html'
            );

            $mailer->send($message);

            // $logger->info('email sent');
            $this->addFlash('reservation_sent', 'Votre demande de reservation a bien été envoyé aux organisateurs, vous receverez une confirmation prochainement.');
            
            return $this->redirectToRoute('home');
        }
        

        return $this->render('billeterie/form.html.twig', [
            'BilleterieForm' => $form->createView(),
            'artists' => $artists,
        ]);

    }

}
