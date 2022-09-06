<?php

namespace App\Mailer;


use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;


class Mail{
    private $mail;

    public function __construct(MailerInterface $mail)
    {
        $this->mail=$mail;

    }
    public function sendEmail(): Void
    {
        $email = (new Email())
            ->from('lavoiedudragonidf@gmail.com')
            ->to('ceyssat.franck@gmail.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $this->mail->send($email);

        // ...
    }
}