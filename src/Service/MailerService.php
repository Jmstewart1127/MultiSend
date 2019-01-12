<?php

namespace Drupal\multisend\Service;

use Drupal\smtp\PHPMailer\PHPMailer;

class MailerService
{
    private $mailer;
    private $config;
    private $attorney_data;

    public function __construct($attorney_data, PHPMailer $mailer)
    {
        $this->mailer = $mailer;
        $this->config = \Drupal::config('multisend.settings');
        $this->attorney_data = $attorney_data;
    }

    public function sendFormData($recipient)
    {
        $this->mailer->SMTPDebug = 2;
        $this->mailer->isSMTP();
        $this->mailer->Host = $this->config->get('smtp_host');
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $this->config->get('smtp_username');
        $this->mailer->Password = $this->config->get('smtp_password');
        $this->mailer->SMTPSecure = 'tls';
        $this->mailer->Port = 587;

        //Recipients
        $this->mailer->setFrom('mcdr@gmail.com', 'McDowell Rice');
        $this->mailer->addAddress($recipient, $recipient);
        $this->mailer->addReplyTo('Jmstewart1127@gmail.com', 'Information');
        $this->mailer->addCC('Jmstewart1127@gmail.com');
        $this->mailer->addBCC('Jmstewart1127@gmail.com');

        //Content
        $this->mailer->isHTML(true);
        $this->mailer->Subject = 'New Contact';
        $this->mailer->Body = 'message sent ' . $this->attorney_data;

        $this->mailer->send();
    }
}
