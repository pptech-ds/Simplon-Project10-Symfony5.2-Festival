<?php

namespace App\Controller;

use App\Service\ArtistHandler;
use App\Service\CategoryHandler;
use App\Repository\ArtistRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArtistController extends AbstractController
{
    private $artistRepository;

    public function __construct(ArtistRepository $artistRepository)
    {
        $this->artistRepository = $artistRepository;
    }

    /**
     * @Route("/artist", name="artist_list", methods={"GET"})
     * @Route("/artist/category/{id}", name="artist_list_by_category", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function list(CategoryHandler $categoryHandler, ArtistHandler $artistHandler, Request $request, $id=null): Response
    {
        // max element per page
        $limit = 9;

        // getting page number
        $page = (int)$request->query->get("page", 1);

        $categories = $categoryHandler->handle();

        $artistsPaginated = $request->get('id') ? 
            $this->artistRepository->findPaginatedArtistsByCategory($request->get('id'), $page, $limit) : 
            $this->artistRepository->findPaginatedArtists($page, $limit);
        // dd($artistsPaginated);

        $artists = $artistHandler->handle($artistsPaginated);

        return $this->render('artist/list.html.twig', [
            'artists' => $artists,
            'categories' => $categories,
            'nbPages' => ceil($artists[0]['NbArtists']/$limit),
        ]);
    }


    /**
     * @Route("/artist/{id}", name="artist_view", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function view($id, Request $request): Response
    {
        $artist = $this->artistRepository->findOneBy(['id'=>$id]);
        $artist->setColor($request->get("color"));

        return $this->render('artist/view.html.twig', [
            'artist' => $artist,
        ]);
    }


    
    
}
