<?php

namespace App\Service;

class ArtistHandler
{
    public function handle($artists)
    {
        $categoryColors = [
            'Mélodique' => 'primary',
            'Industrielle' => 'secondary',
            'Groovy' => 'success',
            'Deep' => 'info',
            'Détroit' => 'warning',
        ];

        foreach ($artists as $artist){
            $color = $artist['0']->getCategory() ? $categoryColors[$artist['0']->getCategory()->getName()] : 'dark';
            $artist['0']->setColor($color);
        }

        return $artists;
    }


}