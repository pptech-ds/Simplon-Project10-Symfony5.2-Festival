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
        // max element per page
        $limit = 9;

        // getting page number
        $page = (int)$request->query->get("page", 1);

        // getting handlers from defined services
        $categories = $categoryHandler->handle();
        $artists = $artistHandler->handle();
        $artistsPaginated = $artistHandler->handlePagination($limit, $page);
        
        // calculating number of total pages
        $nbPages = ceil(count($artists) / $limit);

        return $this->render('artist/list.html.twig', [
            'artists' => $artistsPaginated,
            'categories' => $categories,
            'nbPages' => $nbPages,
        ]);
    }



    /**
     * @Route("/artist/category/{id}", name="artist_list_by_category", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function listByCategory($id, CategoryHandler $categoryHandler, ArtistHandler $artistHandler, Request $request): Response
    {
        // max element per page
        $limit = 9;

        // getting page number
        $page = (int)$request->query->get("page", 1);
        
        // getting handlers from defined services
        $categories = $categoryHandler->handle();
        $artists = $artistHandler->handleByCategory($id);
        $artistsPaginated = $artistHandler->handlePaginationByCategory($id, $limit, $page);

        // calculating number of total pages
        $nbPages = ceil(count($artists) / $limit);

        return $this->render('artist/list.html.twig', [
            'artists' => $artistsPaginated,
            'categories' => $categories,
            'nbPages' => $nbPages,
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
