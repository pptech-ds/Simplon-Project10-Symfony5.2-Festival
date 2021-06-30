<?php

namespace App\Service;

use App\Repository\ArtistRepository;
use Symfony\Component\HttpFoundation\Request;

class ArtistHandler
{
    private $artistRepository;

    public function __construct(ArtistRepository $artistRepository)
    {
        $this->artistRepository = $artistRepository;
    }


    public function handle($artists, $id=null)
    {
        $categoryColors = [
            'Mélodique' => 'primary',
            'Industrielle' => 'secondary',
            'Groovy' => 'success',
            'Deep' => 'info',
            'Détroit' => 'warning',
        ];

        foreach ($artists as $artist){
            $color = $artist->getCategory() ? $categoryColors[$artist->getCategory()->getName()] : 'dark';
            $artist->setColor($color);
        }

        return $artists;
    }


    public function paginate($artists, CategoryHandler $categoryHandler, Request $request, $id=null)
    {
        // max element per page
        $limit = 9;

        // getting page number
        $page = (int)$request->query->get("page", 1);

        // getting handlers from defined services
        $categories = $categoryHandler->handle();

        // $artistsPaginated= [];

        if($id){
            $artists = $this->handle($artists, $id);
            // $artistsPaginated = $this->handlePagination($limit, $page, $id);
            // dd('by ID', $artistsPaginated);
        }
        else{
            $artists = $this->handle($artists);
            // $artistsPaginated = $this->handlePagination($limit, $page);
            // dd('all',$artistsPaginated);
        }
        
        
        // calculating number of total pages
        $nbPages = ceil(count($artists) / $limit);

        // dd($nbPages);

        return [
            'categories' => $categories,
            'artists' => $artists,
            'nbPages' => $nbPages,
        ];
        
    }


    // public function handlePagination($limit, $page, $id=null)
    // {
    //     if($id){
    //         $artistsPaginated = $this->artistRepository->findPaginatedArtistsByCategory($id, $page, $limit);
    //     }
    //     else{
    //         $artistsPaginated = $this->artistRepository->findPaginatedArtists($page, $limit);
    //     }
        

    //     return $artistsPaginated;
    // }


}