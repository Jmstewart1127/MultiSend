<?php

namespace Drupal\multisend\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\multisend\Service\AttorneyService;
use Drupal\multisend\Service\NodeService;
use Drupal\multisend\Service\PracticeAreaService;
use Drupal\node\Entity\Node;

class FormController extends ControllerBase
{
    private $attorneyService;
    private $practiceAreaService;

    public function __construct()
    {
        $this->attorneyService = new AttorneyService();
        $this->practiceAreaService = new PracticeAreaService();
    }

    public function showContactForm()
    {
        $form = $this->getForm();

        return [
            '#theme' => 'multisend_template_form',
            '#form' => $form
        ];
    }

    public function showFormWithAttorney($attorney)
    {
        $form = $this->getForm($attorney);

        $node = Node::load((int)$attorney);

        return [
            '#theme' => 'multisend_template_form_with_attorney',
            '#data' => [
                'form' => $form,
                'attorney' => $node->getTitle(),
                'attorney_alias' => $this->attorneyService->getAttorneyAlias($node->id())
            ],
        ];
    }

    public function showFormForSinglePracticeArea($practiceAreaId)
    {
        $form = $this->getForm();

        $form->set('node_id', $practiceAreaId);

        $node = $this->practiceAreaService->getPracticeAreaById($practiceAreaId);

        return [
            '#theme' => 'multisend_template_form_for_practice_area',
            '#data' => [
                'form' => $form,
                'practice_area' => $node,
            ],
        ];
    }

    public function showFormForAllPracticeAreas()
    {
        $form = $this->getForm();

        $nodes = $this->practiceAreaService->getAllPracticeAreas();

        return [
            '#theme' => 'multisend_template_form_for_all_practice_areas',
            '#data' => [
                'form' => $form,
                'practice_areas' => $nodes,
            ],
        ];
    }

    private function getForm($node_id)
    {
        return \Drupal::formBuilder()
            ->getForm('Drupal\multisend\Form\MultiSendForm', $node_id);
    }
}
