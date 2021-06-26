<?php

namespace App\Service;

use App\Repository\CategoryRepository;

class CategoryHandler
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;

    }

    public function handle()
    {
        $categories = $this->categoryRepository->findAll();

        $categoryColors = [
            'Mélodique' => 'primary',
            'Industrielle' => 'secondary',
            'Groovy' => 'success',
            'Deep' => 'info',
            'Détroit' => 'warning',
        ];

        foreach ($categories as $category){
            $category->setColor($categoryColors[$category->getName()]);
        }

        return $categories;
        
    }
}