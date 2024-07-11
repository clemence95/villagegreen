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

        switch ($type) {
            case 'categorie':
                $resultats = $this->entityManager->createQueryBuilder()
                    ->select('c')
                    ->from(Categorie::class, 'c')
                    ->where('c.nom LIKE :searchTerm')
                    ->setParameter('searchTerm', '%' . $searchTerm . '%')
                    ->getQuery()
                    ->getResult();
                break;
            case 'produit':
                $resultats = $this->entityManager->createQueryBuilder()
                    ->select('p')
                    ->from(Produit::class, 'p')
                    ->where('p.nom LIKE :searchTerm')
                    ->setParameter('searchTerm', '%' . $searchTerm . '%')
                    ->getQuery()
                    ->getResult();
                break;
            default:
                $resultats = [];
                break;
        }

        // Debug dump pour vérification
        dump($searchTerm, $type, $resultats);

        return $this->render('search/index.html.twig', [
            'searchTerm' => $searchTerm,
            'type' => $type,
            'resultats' => $resultats,
        ]);
    }
}




