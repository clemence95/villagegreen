<?php
// src/Controller/MainController.php
namespace App\Controller;

use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    private CategorieRepository $categorieRepository;

    public function __construct(CategorieRepository $categorieRepository)
    {
        $this->categorieRepository = $categorieRepository;
    }

    #[Route('/', name: 'accueil')]
    public function index(CategorieRepository $repo): Response
    {
        $categories = $repo->findBy([ "categorieParent" => null ]);

        // dd($categories);

        return $this->render('catalogue/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/dashboard', name: 'app_dashboard')]
    public function dashboard(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('dashboard/index.html.twig');
    }

    #[Route('/profil', name: 'app_profil')]
    public function profil(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        return $this->render('user/profil.html.twig');
    }
}

