<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FestivalController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        return $this->render('festival/index.html.twig', [
            'controller_name' => 'FestivalController HOME PAGE',
        ]);
    }

    // /**
    //  * @Route("/agenda", name="festival_agenda")
    //  */
    // public function agenda(): Response
    // {
    //     return $this->render('festival/agenda.html.twig', [
    //         'controller_name' => 'FestivalController AGENDA PAGE',
    //     ]);
    // }

    // /**
    //  * @Route("/Billetterie", name="festival_Billetterie")
    //  */
    // public function Billetterie(): Response
    // {
    //     return $this->render('festival/Billetterie.html.twig', [
    //         'controller_name' => 'FestivalController Billetterie PAGE',
    //     ]);
    // }
}
