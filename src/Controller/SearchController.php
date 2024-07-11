<?php

namespace App\Controller;

use App\Entity\Categorie;
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

        // Recherche dans les catégories principales par nom
        $categories = $this->entityManager->getRepository(Categorie::class)
            ->createQueryBuilder('c')
            ->where('c.nom LIKE :searchTerm')
            ->andWhere('c.categorieParent IS NULL') // Seulement les catégories principales
            ->setParameter('searchTerm', '%' . $searchTerm . '%')
            ->getQuery()
            ->getResult();

        // Récupération des sous-catégories associées à chaque catégorie principale trouvée
        $resultats = [];
        foreach ($categories as $categorie) {
            $resultats[] = $categorie;
            foreach ($categorie->getSousCategories() as $sousCategorie) {
                $resultats[] = $sousCategorie;
            }
        }

        // Debug dump pour vérification
        dump($searchTerm, $resultats);

        return $this->render('search/index.html.twig', [
            'searchTerm' => $searchTerm,
            'resultats' => $resultats,
        ]);
    }
}










