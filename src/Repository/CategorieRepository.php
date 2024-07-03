<?php

// src/Repository/CategorieRepository.php
namespace App\Repository;

use App\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

class CategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categorie::class);
    }

    public function findAllWithRelations(): array
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.sousCategories', 'sc')
            ->addSelect('sc')
            ->leftJoin('sc.produits', 'p')
            ->addSelect('p')
            ->getQuery()
            ->getResult();
    }

    public function getAllSousCategories(): array
    {
        $qb = $this->createQueryBuilder('categorie')
            ->leftJoin('categorie.sousCategories', 'sc')
            ->addSelect('sc')
            ->getQuery();

        return $qb->getResult();
    }

    public function findMainCategories(): array
    {
        return $this->createQueryBuilder('c')
            ->where('c.categorieParent IS NULL')
            ->getQuery()
            ->getResult();
    }
    
}

