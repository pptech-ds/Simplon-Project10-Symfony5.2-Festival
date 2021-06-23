<?php

namespace App\Controller;

use App\Form\BilleterieType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
     * @Route("/billeterie", name="billeterie_form")
     */
    public function billterie(): Response
    {
        $form = $this->createForm(BilleterieType::class);

        return $this->render('billeterie/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
