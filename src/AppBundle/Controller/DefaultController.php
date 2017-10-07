<?php

namespace AppBundle\Controller;

use AppBundle\Form\TicketEmbed;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Booking;
use AppBundle\Form\BookingType;
use AppBundle\Form\TicketType;

/**
 * Class LouvreController
 * @package LouvreBundle\Controller
 * @Route("/{_locale}", requirements={"_locale" = "|en|fr"}, defaults={"_locale" = "en"})
 */

class DefaultController extends Controller
{

    /**
     *
     * @Route("/", name="homepage")
     * @Method({"GET", "POST"})
     *
     */
    public function homepageAction(Request $request)
    {
        $locale = $request->getLocale();
        $tarifs = $this->get('tarif.manager')->listTarifs();
        $booking = new Booking();
        $form = $this->get('form.factory')->create(BookingType::class, $booking);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $booking->setBookingDate(new \DateTime());
            $random = uniqid(rand(), false);
            $booking->setCode($random);

            $tarifManager = $this->get('tarif.manager');

            foreach ($booking->getTickets() as $ticket) {
                $birthDate = $ticket->getBirthDate();
                $tarif = $tarifManager->tarifFromAge($birthDate);
                $ticket->setTarif($tarif);
                $ticket->setBooking($booking);
            }
            $em->persist($booking);
            $em->flush();
            $request->getSession()->getFlashBag()->add('messsage', 'Commande ajoutée');
            return $this->redirectToRoute('recap', array('id' => $booking->getId()));
        }
        return $this->render('default/homepage.html.twig', [ 'tarifs' => $tarifs, 'locale' => $locale,'form' => $form->createView(),

        ]);



    }

    /**
     *
     * @Route("/info", name="info")
     * @Method({"GET", "POST"})
     *
     */
    public function orderAction(Request $request)
    {
        $booking = new Booking();
        $form = $this->get('form.factory')->create(BookingType::class, $booking);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $booking->setBookingDate(new \DateTime());
            $random = uniqid(rand(), false);
            $booking->setCode($random);

            $tarifManager = $this->get('tarif.manager');

            foreach ($booking->getTickets() as $ticket) {
                $birthDate = $ticket->getBirthDate();
                $tarif = $tarifManager->tarifFromAge($birthDate);
                $ticket->setTarif($tarif);
                $ticket->setBooking($booking);
            }
            $em->persist($booking);
            $em->flush();
            $request->getSession()->getFlashBag()->add('messsage', 'Commande ajoutée');
            return $this->redirectToRoute('recap', array('id' => $booking->getId()));
        }
        return $this->render('default/info.html.twig', [ 'form' => $form->createView(),

        ]);
    }

    /**
     *
     * @Route("/recap/{id}", name="recap")
     * @Method({"GET", "POST"})
     *
     */
    public function recapAction(Booking $booking)
    {
        $tarifs = $this->get('tarif.manager')->listTarifs();
        $content = $this->get('templating')->render('default/recap.html.twig', ['tarifs' => $tarifs,'booking' => $booking]);
        return new Response($content);
    }



    /**
     * @Route(
     *     "/checkout",
     *     name="order_checkout",
     *     methods="POST"
     * )
     */
    public function checkoutAction()
    {
        \Stripe\Stripe::setApiKey("sk_test_s9GCRFp44l4J91chqcR3TxZj");

        // Get the credit card details submitted by the form
        $token = $_POST['stripeToken'];

        // Create a charge: this will charge the user's card
        try {
            $charge = \Stripe\Charge::create(array(
                "amount" => 1000, // Amount in cents
                "currency" => "eur",
                "source" => $token,
                "description" => "Paiement Stripe - OpenClassrooms Exemple"
            ));
            $this->addFlash("success","Bravo ça marche !");
            return $this->redirectToRoute("recap");
        } catch(\Stripe\Error\Card $e) {

            $this->addFlash("error","Snif ça marche pas :(");
            return $this->redirectToRoute("recap");
            // The card has been declined
        }
    }
}
