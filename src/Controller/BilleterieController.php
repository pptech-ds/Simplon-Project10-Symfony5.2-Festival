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
    public function billterie(UserHandler $userHandler, Request $request): Response
    {
        $user = $userHandler->getUserInfos();
        $date = $request->get("date");
        $plage = $request->get("plage");
        $userEmail = $user->getEmail();
        // dd($date, $plage, $userEmail);

        $form = $this->createForm(BilleterieType::class);

        if($userEmail != null){
            $form->get('Email')->setData($userEmail);
        }

        if($date != null){
            $form->get('Date')->setData($date);
        }

        if($plage != null){
            $form->get('Plage')->setData($plage);
        }
        

        return $this->render('billeterie/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
