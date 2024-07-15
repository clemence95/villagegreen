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
        $resultats = [];

        if ($type === 'categorie') {
            $categories = $this->entityManager->getRepository(Categorie::class)
                ->createQueryBuilder('c')
                ->where('c.nom LIKE :searchTerm')
                ->andWhere('c.categorieParent IS NULL')
                ->setParameter('searchTerm', '%' . $searchTerm . '%')
                ->getQuery()
                ->getResult();

            foreach ($categories as $categorie) {
                foreach ($categorie->getSousCategories() as $sousCategorie) {
                    $resultats[] = ['type' => 'sousCategorie', 'data' => $sousCategorie];
                }
            }
        } elseif ($type === 'produit') {
            $produits = $this->entityManager->getRepository(Produit::class)
                ->createQueryBuilder('p')
                ->where('p.libelleCourt LIKE :searchTerm')
                ->setParameter('searchTerm', '%' . $searchTerm . '%')
                ->getQuery()
                ->getResult();

            foreach ($produits as $produit) {
                $resultats[] = ['type' => 'produit', 'data' => $produit];
            }
        }

        return $this->render('search/index.html.twig', [
            'searchTerm' => $searchTerm,
            'resultats' => $resultats,
        ]);
    }
}












