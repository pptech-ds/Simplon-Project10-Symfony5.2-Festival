<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BilleterieController extends AbstractController
{
    /**
     * @Route("/agenda", name="billeterie_agenda")
     */
    public function agenda(): Response
    {
        $table = [];

        for ($i=0; $i<5; $i++)
        {
            $row = [
                'Date' => '2021/06/21'.$i,
                'Time' => '16:00:00'.$i,
                'Artist' => 'Toto'.$i,
                'Reservation' => 'Reserver une place'.$i
            ]; 
            $table[] = $row;
        }

        // dd($table);

        return $this->render('billeterie/agenda.html.twig', [
            'table_loop' => $table,
        ]);
    }
}
