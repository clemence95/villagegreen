<?php

// src/Controller/EmailTestController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class EmailTestController extends AbstractController
{
    #[Route('/send-test-email', name: 'send_test_email')]
    public function sendTestEmail(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('no-reply@yourdomain.com')
            ->to('test@example.com')
            ->subject('Test Email')
            ->text('This is a test email sent from Symfony using MailHog.');

        $mailer->send($email);

        return new Response('Email sent successfully!');
    }
}
