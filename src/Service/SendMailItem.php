<?php


namespace App\Service;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class SendMailItem extends Controller
{

    private $mailer;
    private $swiftMailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendMailCreateItem()
    {
        $email = (new Email())
            ->from('geekhub031@gmail.com')
            ->to('sasha172017@gmail.com')
            ->subject('Successful created a new item')
            ->html('<p>Successful created a new item</p>');
        $this->mailer->send($email);
    }

    public function sendMailMoveItem()
    {
        $email = (new Email())
            ->from('geekhub031@gmail.com')
            ->to('sasha172017@gmail.com')
            ->subject('Successful moving')
            ->html('<p>Successful moved item</p>');
        $this->mailer->send($email);
    }

}