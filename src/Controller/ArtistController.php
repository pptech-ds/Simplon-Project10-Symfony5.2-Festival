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
     * @Route("/artist", name="artist_list", methods={"GET"})
     * @Route("/artist/category/{id}", name="artist_list_by_category", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function list(ArtistRepository $artistRepository, CategoryHandler $categoryHandler, ArtistHandler $artistHandler, Request $request, $id=null): Response
    {
        // max element per page
        $limit = 9;

        // getting page number
        $page = (int)$request->query->get("page", 1);

        if($request->get('id')){
            $artists = $artistRepository->findByCategory($request->get('id'));

            $artistsPaginated = $artistRepository->findPaginatedArtistsByCategory($request->get('id'), $page, $limit);
            // dd($artistsPaginated);

            $pagination = $artistHandler->paginate($artists, $categoryHandler, $request, $request->get('id'));
        }
        else{
            $artists = $artistRepository->findAll();
            
            $artistsPaginated = $artistRepository->findPaginatedArtists($page, $limit);
            // dd($artistsPaginated);
        
            $pagination = $artistHandler->paginate($artists, $categoryHandler, $request);
        }

        

        return $this->render('artist/list.html.twig', [
            'artists' => $artistsPaginated,
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

        return $this->render('artist/view.html.twig', [
            'artist' => $artist,
        ]);
    }


    
    
}
