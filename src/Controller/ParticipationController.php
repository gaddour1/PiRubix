<?php

namespace App\Controller;
use App\Entity\Participation;
use App\Entity\Evenement;
use App\Form\ParticipationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;


class ParticipationController extends AbstractController
{
    #[Route('/participation', name: 'app_participation')]
    public function index(): Response
    {
        return $this->render('participation/index.html.twig', [
            'controller_name' => 'ParticipationController',
        ]);
    }



    
   /* #[Route('/participate', name: 'participate')]
    public function participatee(Request $request): Response
    {
        $participation = new Participation();

        $form = $this->createForm(ParticipationType::class,$participation);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($participation);//Add
            $em->flush();

            return $this->redirectToRoute('app_participation');
        }
        return $this->render('participation/addParticipation.html.twig',['fo'=>$form->createView()]);

    }*/

    

   /* public function participate(Request $request, EntityManagerInterface $entityManager, $eventId): Response
{
    $event = $entityManager->getRepository(Evenement::class)->find($eventId);

    // Create a new Participation instance and set the event
    $participation = new Participation();
    $participation->setEvenement($event);

    // Create the form and pass the Participation instance
    $form = $this->createForm(ParticipationType::class, $participation);

    // Handle form submission
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        // Persist the participation
        $entityManager->persist($participation);
        $entityManager->flush();

        // Add a flash message
        $this->addFlash('success', 'Your participation has been recorded.');

        // Redirect to a success page or back to the event listing
        return $this->redirectToRoute('eventFront');
    }

    // Render the form template
    return $this->render('participation/addParticipation.html.twig', [
        'form' => $form->createView(),
    ]);
}
*/


#[Route('/join/{eventId}', name: 'participate')]
public function join(Request $request, EntityManagerInterface $entityManager, $eventId): Response
{
    // Load the event details
    $event = $entityManager->getRepository(Evenement::class)->find($eventId);

    // Create a new Participation entity
    $participation = new Participation();

    // Create the participation form
    $form = $this->createForm(ParticipationType::class, $participation);
    $form->handleRequest($request);

    // Handle form submission
    if ($form->isSubmitted() && $form->isValid()) {
        // Set the event ID for the participation
        $participation->setIdEvent($event->getId());
        
        // Persist the participation details
        $entityManager->persist($participation);
        $entityManager->flush();

        // Optionally, add a flash message
        $this->addFlash('success', 'Your participation has been recorded.');

        // Redirect to a success page or back to the event listing
        return $this->redirectToRoute('eventfront');
    }

    // Render the participation form
    return $this->render('participation/addParticipation.html.twig', [
        'fo' => $form->createView(),
    ]);

}

}