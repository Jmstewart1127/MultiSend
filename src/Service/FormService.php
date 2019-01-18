<?php
/**
 * Created by PhpStorm.
 * User: jacobstewart
 * Date: 1/17/19
 * Time: 11:17 PM
 */

namespace Drupal\multisend\Service;


class FormService {

  public function __construct() {}

  public function getAttorneyForm($node_id = NULL) {
    return \Drupal::formBuilder()
      ->getForm('Drupal\multisend\Form\MultiSendForm', $node_id);
  }

  public function getSinglePracticeAreaForm($node_id = NULL) {
    return \Drupal::formBuilder()
      ->getForm('Drupal\multisend\Form\SinglePracticeAreaForm', $node_id);
  }

  public function getPracticeAreasForm() {
    return \Drupal::formBuilder()
      ->getForm('Drupal\multisend\Form\PracticeAreas');
  }

}
