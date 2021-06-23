<?php

namespace App\Controller;

use App\Entity\Artist;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArtistController extends AbstractController
{
    /**
     * @Route("/artist", name="artist_home")
     */
    public function home(): Response
    {
        $artists = $this->getDoctrine()->getRepository(Artist::class)->findAll();

        // dd($artists);

        return $this->render('artist/home.html.twig', [
            'artists' => $artists,
        ]);
    }

    /**
     * @Route("/artist/{id}", name="artist_view", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function view($id, Request $request): Response
    {
        $artist = $this->getDoctrine()->getRepository(Artist::class)->findOneBy(['id'=>$id]);

        return $this->render('artist/view.html.twig', [
            'artist' => $artist,
        ]);
    }


    /**
     * @Route("/artist/category/{id}", name="artist_view_by_category", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function viewByCategory($id): Response
    {
        $artist = $this->getDoctrine()->getRepository(Artist::class)->findByCategory($id);

        dd($artist);

        return $this->render('artist/view.html.twig', [
            'artist' => $artist,
        ]);
    }
}
