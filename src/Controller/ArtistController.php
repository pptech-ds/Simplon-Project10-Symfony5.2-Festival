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
        // On définit le nombre d'éléments par page
        $limit = 9;

        // On récupère le numéro de page
        $page = (int)$request->query->get("page", 1);

        // $artistsAll = $artistRepository->findAll();
        $artists = $artistRepository->findAllAndCount();
        $categories = $categoryRepository->findAll();

        $artistsPaginated = $artistRepository->getPaginatedArtists($page, $limit);

        // dd($artistsAll);
        // dd($artists);
        // dd($artistsPaginated);

        $nbPages = ceil($artists[0]["NbArtists"] / $limit);
        

        // for($i=0; $i<$nbPages; $i++){
        //     echo 'page '.$i.'<br>';
        // }

        // dd($nbPages);

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
    public function viewByCategory($id): Response
    {
        $artists = $this->getDoctrine()->getRepository(Artist::class)->findByCategory($id);
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();

        // dd($artist);

        return $this->render('artist/home.html.twig', [
            'artists' => $artists,
            'categories' => $categories,
        ]);
    }


    /**
     * @Route("/artist/category_test/{id}/{nbPage}", name="artist_view_by_category_test", methods={"GET"}, requirements={"id"="\d+", "nbPage"="\d+"})
     */
    public function viewByCategoryTest($id, $nbPage, ArtistRepository $artistRepository, CategoryRepository $categoryRepository, Request $request): Response
    {
        // On définit le nombre d'éléments par page
        $limit = 9;

        // On récupère le numéro de page
        // $page = (int)$request->query->get("page", 1);
        // $id = $request->query->get("id");

        // dd($id);
        dd($nbPage);

        // $artistsAll = $artistRepository->findAll();
        $artists = $artistRepository->findAllAndCount();
        $categories = $categoryRepository->findAll();

        $artistsPaginated = $artistRepository->getPaginatedArtists($page, $limit);

        // dd($artistsAll);
        // dd($artists);
        // dd($artistsPaginated);

        $nbPages = ceil($artists[0]["NbArtists"] / $limit);
        

        // for($i=0; $i<$nbPages; $i++){
        //     echo 'page '.$i.'<br>';
        // }

        // dd($nbPages);

        return $this->render('artist/home.html.twig', [
            'artists' => $artistsPaginated,
            'categories' => $categories,
            'nbPages' => 10,
        ]);
    }
}
