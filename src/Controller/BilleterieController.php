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

        for ($i=0; $i<9; $i++)
        {
            // if($i %3 = 0){
            $row = [
                'Date' => '2021/06/2'.$i,
                'Time' => '16:00:0'.$i,
                'Artist' => 'Artiste '.$i,
                'Reservation' => 'Reserver une place'
            ]; 
            $table[] = $row;
        }

        // dd($table);

        return $this->render('billeterie/agenda.html.twig', [
            'table_loop' => $table,
        ]);
    }


    /**
     * @Route("/billeterie", name="billeterie_billeterie")
     */
    public function billeterie(): Response
    {
        $table = [];

        for ($i=0; $i<9; $i++)
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
