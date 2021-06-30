<?php

namespace App\Service;

// use Symfony\Component\Security\Core\User\UserInterface;


class BilletterieHandler 
{
    public function mailer($emailTitle, $emailTo, $emailBody, $user, $mailer) : void
    {
        // $response = false;

        $message = new \Swift_Message($emailTitle);
        $message->setFrom($user->getEmail());
        $message->setTo($emailTo);
        $message->setBody($emailBody,
            'text/html'
        );

        $mailer->send($message);

        // dd($mailer->);

        // $response = true;

        // return $response;
    }
}