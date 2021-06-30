<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Entity\Category;
use App\Service\ArtistHandler;
use App\Service\CategoryHandler;
use App\Repository\ArtistRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArtistController extends AbstractController
{
    /**
     * @Route("/artist", name="artist_list")
     */
    public function list(CategoryHandler $categoryHandler, ArtistHandler $artistHandler, Request $request): Response
    {
        $pagination = $artistHandler->paginate($id=null, $categoryHandler, $request);

        return $this->render('artist/list.html.twig', [
            'artists' => $pagination['artistsPaginated'],
            'categories' => $pagination['categories'],
            'nbPages' => $pagination['nbPages'],
        ]);
    }



    /**
     * @Route("/artist/category/{id}", name="artist_list_by_category", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function listByCategory($id, CategoryHandler $categoryHandler, ArtistHandler $artistHandler, Request $request): Response
    {
        $pagination = $artistHandler->paginate($id, $categoryHandler, $request);

        return $this->render('artist/list.html.twig', [
            'artists' => $pagination['artistsPaginated'],
            'categories' => $pagination['categories'],
            'nbPages' => $pagination['nbPages'],
        ]);
    }



    /**
     * @Route("/artist/{id}", name="artist_view", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function view($id, ArtistRepository $artistRepository, Request $request): Response
    {
        $artist = $artistRepository->findOneBy(['id'=>$id]);
        $artist->setColor($request->get("color"));

        // dd($artist, $request->get("color"));

        return $this->render('artist/view.html.twig', [
            'artist' => $artist,
        ]);
    }
    
}
