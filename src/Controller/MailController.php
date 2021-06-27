<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MailController extends AbstractController
{
    /**
     * @Route("/mail", name="mail")
     */
    public function mail(Request $request, \Swift_Mailer $mailer)
    {
        // $form = $event->getForm();
        // $dataForm = $form->getData();
        // $BilleterieForm = $request->get('BilleterieForm');
        // $postData = $request->request->get('contact');

        dd('$dataForm');

        $message = new \Swift_Message('Test email');
        $message->setFrom('admin@zetcode.com');
        $message->setTo('admin2@zetcode.com');
        $message->setBody(
            $this->renderView(
                'email/reservation.html.twig',
            ),
            'text/html'
        );

        $mailer->send($message);

        // $logger->info('email sent');
        $this->addFlash('notice', 'Email sent');

        return $this->redirectToRoute('home');
    }
}