<?php
namespace App\Controller;

use DateTime;
use DateTimeInterface;
use DateTimeZone;
use App\Entity\Evenement;
use App\Form\EventType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Asset\Packages;
use App\Repository\EvenementRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Knp\Component\Pager\PaginatorInterface;


class EvenementController extends AbstractController
{
    #[Route('/event', name: 'app_e')]
    public function index(Packages $assetPackages): Response
{
    $events = $this->getDoctrine()->getManager()->getRepository(Evenement::class)->findAll();
    $imagePath = $assetPackages->getUrl('uploads/');

    return $this->render('evenement/index.html.twig', [
        'evenements' => $events,
        'image_path' => $imagePath,
    ]);
}

 
    #[Route('/adde', name: 'adde')]
    public function adde(Request $request): Response
    {
        $event = new evenement();

        $form = $this->createForm(EventType::class,$event);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);//Add
            $em->flush();

            return $this->redirectToRoute('app_back');
        }
        return $this->render('evenement/addEvent.html.twig',['f'=>$form->createView()]);

    }


    #[Route('/deleteEvent/{id}', name: 'deleteEvent')]

 public function deleteEvent(evenement $event): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($event);
        $em->flush();

        return $this->redirectToRoute('app_back');



}

#[Route('/update/{id}', name: 'updateEvent')]
    public function updateEvent(Request $request,$id): Response
    {
        $event = $this->getDoctrine()->getManager()->getRepository(Evenement::class)->find($id);
        $form = $this->createForm(EventType::class,$event);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('app_back');
        }
        return $this->render('evenement/updateEvent.html.twig',['e'=>$form->createView()]);

    }

         //afficher un voyage par details
#[Route('/showe/{id}', name: 'showEvent')]
   
    public function show(evenement $event): Response
    {
        return $this->render('evenement/showEvent.html.twig', [
            'event' => $event,
        ]);
    }


  
    #[Route('/eventfront', name: 'eventfront')]
    public function eventfront(Request $request, EvenementRepository $EvenementRepository, PaginatorInterface $paginator): Response
    {
        // Méthode findBy qui permet de récupérer les données avec des critères de filtre et de tri
        $donnees = $this->getDoctrine()->getRepository(Evenement::class)->findAll();
        $event = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos événements)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            4 // Nombre de résultats par page
        );
    
        return $this->render('evenement/listEvent.html.twig', [
            'event' => $event,
        ]);
    }


    public function participate(Request $request, EntityManagerInterface $entityManager, $eventId): Response
{
    $event = $entityManager->getRepository(Event::class)->find($eventId);
    $participation = new Participation();
    $participation->setIdEvent($event); // Set the event ID for the participation

    $form = $this->createForm(ParticipationType::class, $participation);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Save the participation details
        $entityManager->persist($participation);
        $entityManager->flush();

        // Optionally, add a flash message
        $this->addFlash('success', 'Your participation has been recorded.');

        // Redirect to a success page or back to the event listing
        return $this->redirectToRoute('event_listing');
    }

    return $this->render('participation/form.html.twig', [
        'form' => $form->createView(),
    ]);
}

    }

    
