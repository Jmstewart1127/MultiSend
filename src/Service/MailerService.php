<?php

namespace Drupal\multisend\Service;

use Drupal\smtp\PHPMailer\PHPMailer;

class MailerService
{
    private $mailer;
    private $config;
    private $attorneyService;
    private $practiceAreaService;
    private $nodeId;
    private $TEMPLATE_TYPE = [
        'PRACTICE_AREA',
        'ALL_PRACTICE_AREAS',
        'ATTORNEY'
    ];

    public function __construct(PHPMailer $mailer, $nodeId)
    {
        $this->mailer = $mailer;
        $this->nodeId = $nodeId;
        $this->config = \Drupal::config('multisend.settings');
        $this->attorneyService = new AttorneyService();
        $this->practiceAreaService = new PracticeAreaService();
    }

    public function sendFormData($TEMPLATE_TYPE, $recipient)
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
        $this->mailer->Body = $this->selectFormTemplate($TEMPLATE_TYPE);

        $this->mailer->send();
    }

    private function selectFormTemplate($TEMPLATE_TYPE)
    {
        switch ($TEMPLATE_TYPE) {
            case 'PRACTICE_AREA':
                return $this->getPracticeAreaTemplate();
            case 'PRACTICE_AREAS':
                return $this->getAllPracticeAreasTemplate();
            case 'ATTORNEY':
                return $this->getAttorneyTemplate();
        }
    }

    private function getPracticeAreaTemplate()
    {


        $template = '';



        return $template;
    }

    private function getAllPracticeAreasTemplate()
    {
        $template = '';


        return '';
    }

    private function getAttorneyTemplate()
    {
        $attorney = $this->attorneyService->getAttorneyDataById($this->nodeId);

        $template =  '<p>'. $attorney['name'] .'</p>';
        $template .= '<p>'. $attorney['bar_admissions'] .'</p>';
        $template .= '<p>'. $attorney['court_admissions'] .'</p>';
        $template .= '<p>'. $attorney['education'] .'</p>';
        $template .= '<p>'. $attorney['linkedin'] .'</p>';
        $template .= '<p>'. $attorney['phone'] .'</p>';
        $template .= '<ul>';

        foreach ($attorney['practice_areas'] as $practice_area)
        {
            $template .=
                '<li><a href="'. $practice_area['practice_area_alias'] .'">'
                . $practice_area['practice_area'] .
                '</a></li>';
        }

        $template .= '</ul>';

        return $template;
    }
}
