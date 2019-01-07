<?php

namespace Drupal\multisend\Service;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class MailerService
{
    private $mailer;
    private $config;
    private $attorney_data;

    public function __construct($attorney_data)
    {
        $this->mailer = new PHPMailer(true);
        $this->config = \Drupal::config('multisend.settings');
        $this->attorney_data = $attorney_data;
    }

    public function sendFormData($recipient)
    {
        try {
            $this->mailer->SMTPDebug = 2;
            $this->mailer->isSMTP();
            $this->mailer->Host = $this->config->get('smtp_host');
            $this->mailer->SMTPAuth = false;
            $this->mailer->Username = $this->config->get('smtp_username');
            $this->mailer->Password = $this->config->get('smtp_password');
            $this->mailer->SMTPSecure = 'tls';
            $this->mailer->Port = 587;

            //Recipients
            $this->mailer->setFrom('mrsb@gmail.com', 'mrsb');
            $this->mailer->addAddress($recipient, $recipient);
            $this->mailer->addReplyTo('Jmstewart1127@gmail.com', 'Information');
            $this->mailer->addCC('Jmstewart1127@gmail.com');
            $this->mailer->addBCC('Jmstewart1127@gmail.com');

            //Content
            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'New Contact';
            $this->mailer->Body = $this->renderEmailTemplate();

            $this->mailer->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $this->mailer->ErrorInfo;
        }
    }

    private function renderEmailTemplate()
    {
        ?>
            <h3><?=$this->attorney_data ?></h3>
            <h3></h3>
            <h3></h3>
            <h3></h3>
            <h3></h3>
        <?php
    }
}
