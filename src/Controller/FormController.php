<?php

namespace Drupal\multisend\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Drupal\node\NodeInterface;


class FormController extends ControllerBase
{
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
        $form = $this->getForm();

        $node = Node::load((int)$attorney);

        return [
            '#theme' => 'multisend_template_form_with_attorney',
            '#data' => [
                'form' => $form,
                'attorney' => $node->getTitle(),
                'attorney_alias' => $this->getNodeAlias($node->id())
            ],
        ];
    }

    private function getForm()
    {
        return \Drupal::formBuilder()
            ->getForm('Drupal\multisend\Form\MultiSendForm');
    }

    private function getNodeAlias($nid)
    {
        return \Drupal::service('path.alias_manager')
            ->getAliasByPath('/node/'.$nid);
    }
}
