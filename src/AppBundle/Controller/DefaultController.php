<?php

namespace AppBundle\Controller;

use AppBundle\Form\TicketEmbed;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Booking;
use AppBundle\Form\Type\BookingType;
use AppBundle\Form\Type\TicketType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Stripe\Charge;
use Stripe\Error\Card;
use Stripe\Stripe;
use Symfony\Component\HttpFoundation\Session\Session;

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



        return $this->render('default/homepage.html.twig', [ 'tarifs' => $tarifs, 'locale' => $locale]);
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

        if ($form->isSubmitted() && $form->isValid()) {

            $this->get('session.booking')->setSessionBooking($booking);

            $request->getSession()->getFlashBag()->add('messsage', 'Commande ajoutée');
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

        $booking = $this->container->get('session.booking')->getSessionBooking();
        $this->get('session.booking')->setSessionBooking($booking);


        return $this->render('default/recap.html.twig', array(
            'booking' => $booking,
        ));
    }



        /**
         * @Route("/checkout", name="order_checkout")
         * @param Request $request
         * @return \Symfony\Component\HttpFoundation\RedirectResponse
         * @Method({"POST"})
         */
        public function checkoutAction(Request $request)
    {

        $booking = $this->container->get('session.booking')->getSessionBooking();

        Stripe::setApiKey($this->getParameter('stripe_api_key'));
        // Get the credit card details submitted by the form
        $token = $request->request->get('stripeToken');


        // Create a charge: this will charge the user's card
        try {
            Charge::create(array(
                "amount" => $booking->getTotalMount()*100,

                "currency" => "eur",
                "source" => $token,
                "description" => "Musée du Louvre"
            ));
            $this->addFlash("success",'msgFlash.checkOutSucces');
            $booking->setToken($token);
            $this->container->get('session.booking')->setSessionBooking($booking);
            return $this->redirectToRoute('validate', array('id' => $booking->getId()));
        } catch(Card $e) {
            $this->addFlash("error",$this->get('translator')->trans('msgFlash.checkOutError'));
            return $this->redirectToRoute('recap');
            // The card has been declined
        }
    }

    /**
     * @Route("/validate", name="validate")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Method({"GET"})
     */
    public function validateAction()
    {

        {

            $booking = $this->get('session.booking')->getSessionBooking();
            $this->container->get('session.booking')->saveBooking($booking);
            if ($booking->getToken() || $booking->getTotalMount() == 0) {
                // Envoie Email
                $this->container->get('app.sendEmail')->sendEmail($booking);
            }

            return $this->render('default/validate.html.twig');
        }
    }






}
