<?php
/**
 * Created by PhpStorm.
 * User: Frs
 * Date: 13/10/2017
 * Time: 06:36
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Booking;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Stripe\Charge;
use Stripe\Error\Card;
use Stripe\Stripe;


class PaymentController
{
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
        $token = $request->request->get('stripeToken');


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
            $this->get('session.booking')->setSessionBooking($booking);
            $this->container->get('session.booking')->saveBooking($booking);
            if ($booking->getToken() || $booking->getTotalMount() == 0) {
                // Envoie Email
                $this->container->get('app.sendEmail')->sendEmail($booking);
            }

            return $this->render('default/validate.html.twig', ['booking' => $booking]);
        }
    }

}
