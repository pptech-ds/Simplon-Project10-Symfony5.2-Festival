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



    public function handle()
    {
        $artists = $this->artistRepository->findAll();

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



    public function handleByCategory($id)
    {
        $artists = $this->artistRepository->findByCategory($id);

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


    public function handlePagination($limit, $page)
    {
        $artistsPaginated = $this->artistRepository->findPaginatedArtists($page, $limit);

        return $artistsPaginated;
    }


    public function handlePaginationByCategory($id, $limit, $page)
    {
        $artistsPaginated = $this->artistRepository->findPaginatedArtistsByCategory($id, $page, $limit);

        return $artistsPaginated;
    }

}