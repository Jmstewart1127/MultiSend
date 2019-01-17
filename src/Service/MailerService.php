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
    private $baseUrl;
    private $TEMPLATE_TYPE = [
        'PRACTICE_AREA',
        'ALL_PRACTICE_AREAS',
        'ATTORNEY'
    ];

    public function __construct(PHPMailer $mailer, $nodeId = null)
    {
        $this->mailer = $mailer;
        $this->nodeId = $nodeId;
        $this->baseUrl = \Drupal::request()->getSchemeAndHttpHost();
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
                return $this->getSinglePracticeAreaTemplate();
            case 'PRACTICE_AREAS':
                return $this->getAllPracticeAreasTemplate();
            case 'ATTORNEY':
                return $this->getAttorneyTemplate();
        }
    }

    private function getSinglePracticeAreaTemplate()
    {
        $single_practice_area = $this->practiceAreaService
            ->getSinglePracticeAreaDataById($this->nodeId);

        $template = '<h3>' . $single_practice_area['practice_area_title'] . '</h3><hr>';
        $template .= '<h3>Chairs</h3><hr>';
        $template .= '<ul>';

        foreach ($single_practice_area['practice_area_chairs'] as $chair)
        {
            $template .=
                '<li>' .
                    '<a href="' . $this->baseUrl . $chair['chair_alias'] . '">'
                        . $chair['name_title'] .
                    '</a>' .
                '</li>';
        }

        $template .= '</ul>';
        $template .= '<h3>Members of Practice</h3><hr>';
        $template .= '<ul>';

        foreach ($single_practice_area['practice_area_members'] as $member)
        {
            $template .=
                '<li>' .
                    '<a href="' . $this->baseUrl . $member['member_alias'] . '">'
                        . $chair['member_name'] .
                    '</a>' .
                '</li>';
        }

        $template .= '</ul>';

        return $template;
    }

    private function getAllPracticeAreasTemplate()
    {
        $practice_areas = $this->practiceAreaService->getAllPracticeAreas();

        $template = '<h3>Practice Areas</h3><hr>';
        $template .= '<ul>';

        foreach ($practice_areas as $practice_area)
        {
            $template .=
                '<li>' .
                    '<a href="' . $this->baseUrl . $practice_area['alias'] . '">'
                        . $practice_area['title'] .
                    '</a>' .
                '</li>';
        }

        $template .= '</ul>';

        return $template;
    }

    private function getAttorneyTemplate()
    {
        $attorney = $this->attorneyService->getAttorneyDataById($this->nodeId);

        $template .=  '<h3>Attorney</h3><hr>';
        $template =  '<p>'. $attorney['name'] .'</p>';
        $template .=  '<h3>Bar Admissions</h3><hr>';
        $template .= '<p>'. $attorney['bar_admissions'] .'</p>';
        $template .=  '<h3>Court Admissions</h3><hr>';
        $template .= '<p>'. $attorney['court_admissions'] .'</p>';
        $template .=  '<h3>Education</h3><hr>';
        $template .= '<p>'. $attorney['education'] .'</p>';
        $template .=  '<h3>Contact Info</h3><hr>';
        $template .= '<p>'. $attorney['linkedin'] .'</p>';
        $template .= '<p>'. $attorney['phone'] .'</p>';
        $template .=  '<h3>Practice Areas</h3><hr>';
        $template .= '<ul>';

        foreach ($attorney['practice_areas'] as $practice_area)
        {
            $template .=
                '<li><a href="'. $this->baseUrl . $practice_area['practice_area_alias'] .'">'
                . $practice_area['practice_area'] .
                '</a></li>';
        }

        $template .= '</ul>';

        foreach ($attorney['bio_tabs'] as $bio_tab)
        {
            $template .= '<h3>' . $bio_tab['title'] . '</h3><hr>';
            $template .= '<p>' . $bio_tab['body'] . '</p>';
        }

        return $template;
    }
}
