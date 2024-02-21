<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Asset\Packages;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Evenement;
use App\Form\EventType;

class BackController extends AbstractController
{
    #[Route('/back', name: 'app_back')]
    public function index(Packages $assetPackages): Response
    {$events = $this->getDoctrine()->getManager()->getRepository(Evenement::class)->findAll();
        $imagePath = $assetPackages->getUrl('uploads/');
        return $this->render('back/back.html.twig', [
           
            'evenements' => $events,
        'image_path' => $imagePath,
        ]);
    }


}


