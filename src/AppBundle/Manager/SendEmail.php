<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Booking;
use Symfony\Component\Templating\EngineInterface;

class SendEmail
{

    protected $templating;
    protected $mailer;

    public function __construct(EngineInterface $templating, \Swift_Mailer $mailer)
    {
        $this->templating = $templating;
        $this->mailer = $mailer;
    }


    /**
     *
     * @param Booking $booking
     *
     */
    public function sendEmail(Booking $booking)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('Réservation de tickets pour le musée du Louvre')
            ->setFrom(array('projetlouvrep4@gmail.com' => 'Musée du Louvre'))
            ->setTo($booking->getEmail())
            ->setCharset('utf-8')
            ->setContentType('text/html')
            ->setBody(
                $this->templating->render('emails/email.html.twig', array('booking' => $booking)),
                'text/html'
            )
        ;
        $this->mailer->send($message);
    }
}
