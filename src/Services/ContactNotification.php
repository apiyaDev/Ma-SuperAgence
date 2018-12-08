<?php

namespace App\Services;

use App\Entity\Contact;
use Twig\Environment;

class ContactNotification
{

    /**
     * @var \Swift_Mailer
     */
    private $swift;

    /**
     * @var Environment
     */
    private $rendered;

    public function __construct(\Swift_Mailer $swift, Environment $rendered)
    {
        $this->swift = $swift;
        $this->rendered = $rendered;
    }

    public function contactSend(Contact $contact)
    {

        $message = (new \Swift_Message('Agence : title '))
                   ->setFrom($contact->getEmail())
                   ->setTo('saidmounaim00@gmail.com')
                   ->setBody($this->rendered->render('emails/contact.html.twig', [
                       'contact' => $contact
                   ]), 'text/html')
        ;           
                    
        $this->swift->send($message);           

    }

}