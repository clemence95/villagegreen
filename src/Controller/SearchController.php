<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Produit;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

class SearchController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/search", name="search", methods={"GET"})
     */
    public function search(Request $request): Response
    {
        $searchTerm = $request->query->get('query');
        $type = $request->query->get('type');

        $query = null;
        $resultats = [];

        if ($searchTerm) {
            switch ($type) {
                case 'categorie':
                    $query = $this->entityManager->createQuery(
                        'SELECT c FROM App\Entity\Categorie c WHERE c.nom LIKE :searchTerm'
                    )->setParameter('searchTerm', '%' . $searchTerm . '%');
                    break;
                case 'produit':
                    $query = $this->entityManager->createQuery(
                        'SELECT p FROM App\Entity\Produit p WHERE p.libelleCourt LIKE :searchTerm OR p.libelleLong LIKE :searchTerm'
                    )->setParameter('searchTerm', '%' . $searchTerm . '%');
                    break;
                default:
                    // Si le type est invalide ou non défini, recherchez dans les deux tables
                    $categorieQuery = $this->entityManager->createQuery(
                        'SELECT c FROM App\Entity\Categorie c WHERE c.nom LIKE :searchTerm'
                    )->setParameter('searchTerm', '%' . $searchTerm . '%');

                    $produitQuery = $this->entityManager->createQuery(
                        'SELECT p FROM App\Entity\Produit p WHERE p.libelleCourt LIKE :searchTerm OR p.libelleLong LIKE :searchTerm'
                    )->setParameter('searchTerm', '%' . $searchTerm . '%');

                    $resultats = array_merge(
                        $categorieQuery->getResult(),
                        $produitQuery->getResult()
                    );
            }

            if ($query) {
                $resultats = $query->getResult();
            }
        }

        // Debug dump pour vérification des résultats
        dump($searchTerm, $type, $resultats);

        return $this->render('search/index.html.twig', [
            'searchTerm' => $searchTerm,
            'type' => $type,
            'resultats' => $resultats,
        ]);
    }
}








