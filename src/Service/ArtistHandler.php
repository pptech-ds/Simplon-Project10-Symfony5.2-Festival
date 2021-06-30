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


    public function handle($id=null)
    {
        if($id){
            $artists = $this->artistRepository->findByCategory($id);
        }
        else{
            $artists = $this->artistRepository->findAll();
        }
        
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


    public function paginate($id=null, CategoryHandler $categoryHandler, Request $request)
    {
        // max element per page
        $limit = 9;

        // getting page number
        $page = (int)$request->query->get("page", 1);

        // getting handlers from defined services
        $categories = $categoryHandler->handle();

        // $artistsPaginated= [];

        if($id){
            $artists = $this->handle($id);
            $artistsPaginated = $this->handlePagination($id, $limit, $page);
            // dd('by ID', $artistsPaginated);
        }
        else{
            $artists = $this->handle();
            $artistsPaginated = $this->handlePagination($id=null, $limit, $page);
            // dd('all',$artistsPaginated);
        }
        
        
        // calculating number of total pages
        $nbPages = ceil(count($artists) / $limit);

        // dd($nbPages);

        return [
            'categories' => $categories,
            'artists' => $artists,
            'artistsPaginated' => $artistsPaginated,
            'nbPages' => $nbPages,
        ];
        
    }


    public function handlePagination($id=null, $limit, $page)
    {
        if($id){
            $artistsPaginated = $this->artistRepository->findPaginatedArtistsByCategory($id, $page, $limit);
        }
        else{
            $artistsPaginated = $this->artistRepository->findPaginatedArtists($page, $limit);
        }
        

        return $artistsPaginated;
    }


}