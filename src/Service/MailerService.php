<?php

use PHPMailer\PHPMailer\PHPMailer;

/**
 * Created by PhpStorm.
 * User: jacobstewart
 * Date: 1/5/19
 * Time: 3:22 PM
 */


class MailerService
{
    private $smtpHost;
    private $smtpUsername;
    private $smtpPassword;
    private $mailer;

    public function __construct($host, $username, $password)
    {
        $this->smtpHost = $host;
        $this->smtpUsername = $username;
        $this->smtpPassword = $password;
        $this->mailer = new PHPMailer(true);
    }

    public function sendFormData($recipient, $sender)
    {
        try {
            $this->mailer->SMTPDebug = 2;
            $this->mailer->isSMTP();
            $this->mailer->Host = $this->smtpHost;
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = $this->smtpUsername;
            $this->mailer->Password = $this->smtpPassword;
            $this->mailer->SMTPSecure = 'tls';
            $this->mailer->Port = 587;

            //Recipients
            $this->mailer->setFrom($form_data['email'], $form_data['first_name'] . ' ' . $form_data['last_name']);
            $this->mailer->addAddress($recipient, $recipient);     // Add a recipient
            $this->mailer->addReplyTo('Jmstewart1127@gmail.com', 'Information');
            $this->mailer->addCC('Jmstewart1127@gmail.com');
            $this->mailer->addBCC('Jmstewart1127@gmail.com');

            //Content
            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'New Contact';
            $this->mailer->Body = $this->renderEmailTemplate($sender);

            $this->mailer->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $this->mailer->ErrorInfo;
        }
    }

    private function renderEmailTemplate($sentFrom)
    {
        ?>

        <?php
    }
}
