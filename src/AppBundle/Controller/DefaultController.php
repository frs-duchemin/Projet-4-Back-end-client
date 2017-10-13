<?php

namespace AppBundle\Controller;

use AppBundle\Form\TicketEmbed;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
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
            $this->container->get('app.sessionBooking')->setSessionClient($booking);

            return $this->redirectToRoute('recap', array('id' => $booking->getId()));
        }
        return $this->render('default/homepage.html.twig', [ 'tarifs' => $tarifs, 'locale' => $locale,'form' => $form->createView(),

        ]);
    }

    /**
     * @param Request $request
     * @Route("/order", name="order")
     * @Method({"GET", "POST"})
     * @return Response
     * @return \Symfony\Component\HttpFoundation\Response
     * @Template()
     */

    public function orderAction(Request $request)
    {

        $booking = new Booking();

        $form = $this->get('form.factory')->create(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->get('session.booking')->setSessionBooking($booking);


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

            $request->getSession()->getFlashBag()->add('messsage', 'Commande ajoutée');
            $this->get('session.booking')->setSessionBooking($booking);
            return $this->redirectToRoute('recap');
        }
        return $this->render('default/order.html.twig', [ 'form' => $form->createView(),

        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/recap", name="recap")
     * @Method({"GET", "POST"})
     *
     */
    public function recapAction()
    {
        $booking = $this->get('session.booking')->getSessionBooking();
        $this->get('session.booking')->setSessionBooking($booking);

        $content = $this->get('templating')->render('default/recap.html.twig', ['booking' => $booking]);
        return new Response($content);
    }










}
