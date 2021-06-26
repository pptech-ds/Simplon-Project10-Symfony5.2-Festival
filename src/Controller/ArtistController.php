<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Entity\Category;
use App\Repository\ArtistRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArtistController extends AbstractController
{
    /**
     * @Route("/artist", name="artist_home")
     */
    public function home(ArtistRepository $artistRepository, CategoryRepository $categoryRepository, Request $request): Response
    {
        // max element per page
        $limit = 9;

        // getting page number
        $page = (int)$request->query->get("page", 1);

        $artists = $artistRepository->findAll();
        $categories = $categoryRepository->findAll();

        // getting paginated artists
        $artistsPaginated = $artistRepository->findPaginatedArtists($page, $limit);

        $nbPages = ceil(count($artists) / $limit);
        
        return $this->render('artist/home.html.twig', [
            'artists' => $artistsPaginated,
            'categories' => $categories,
            'nbPages' => $nbPages,
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
    public function viewByCategory($id, ArtistRepository $artistRepository, CategoryRepository $categoryRepository, Request $request): Response
    {
        // max element per page
        $limit = 9;

        // getting page number
        $page = (int)$request->query->get("page", 1);
        
        $artists = $artistRepository->findByCategory($id);
        $categories = $categoryRepository->findAll();

        $artistsPaginated = $artistRepository->findPaginatedArtistsByCategory($id, $page, $limit);

        $nbPages = ceil(count($artists) / $limit);

        return $this->render('artist/home.html.twig', [
            'artists' => $artistsPaginated,
            'categories' => $categories,
            'nbPages' => $nbPages,
        ]);
    }
}
