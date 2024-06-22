<?php
// src/Controller/SecureController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/secure", name="secure")
 * @IsGranted("ROLE_USER")
 */
class SecureController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecureController',
        ]);
    }
}

