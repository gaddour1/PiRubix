<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppointementController extends AbstractController
{
    #[Route('/appointement', name: 'app_appointement')]
    public function index(): Response
    {
        return $this->render('appointement/index.html.twig', [
            'controller_name' => 'AppointementController',
        ]);
    }
}
