<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class SendMailProduct extends AbstractController
{

    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendMailCreateProduct()
    {
        $email = (new Email())
            ->from('geekhub031@gmail.com')
            ->to('sasha172017@gmail.com')
            ->subject('Successful created a new item')
            ->html('<p>Successful created a new item</p>');
        $this->mailer->send($email);
    }


}