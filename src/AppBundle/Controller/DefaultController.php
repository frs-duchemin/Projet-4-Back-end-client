<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Booking;
use AppBundle\Form\BookingType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $tarifs = $this->get('tarif.manager')->listTarifs();
        $content = $this->get('templating')->render('default/index.html.twig',
            ['tarifs' => $tarifs]);
        return new Response($content);
    }



    /**
     * @Route("/info", name="info")
     */
     public function orderAction(Request $request)
     {
         $booking = new Booking();
         $form = $this->get('form.factory')->create(BookingType::class, $booking);
         if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
             $em = $this->getDoctrine()->getManager();
             $booking->setDateCommande(new \DateTime());
             $random = uniqid(rand(), false);
             $booking->setCode($random);

             $tarifManager = $this->get('tarif.manager');

             foreach ($booking->getBillets() as $ticket) {
                 $dateNaissance = $ticket->getDateNaissance();
                 $tarif = $tarifManager->tarifFromAge($dateNaissance);
                 $ticket->setTarif($tarif);
                 $ticket->setCommande($booking);
             }
             $em->persist($booking);
             $em->flush();
             $request->getSession()->getFlashBag()->add('messsage', 'Commande ajoutée');
             return $this->redirectToRoute('frs_louvre_recapitulatif', array('id' => $booking->getId()));
         }
         return $this->render('default/info.html.twig', array('form' => $form->createView(),));
     }
}
