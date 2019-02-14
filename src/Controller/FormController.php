<?php

namespace Drupal\multisend\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\multisend\Service\AttorneyService;
use Drupal\multisend\Service\FormService;
use Drupal\multisend\Service\NewsService;
use Drupal\multisend\Service\PracticeAreaService;

class FormController extends ControllerBase {

  private $attorneyService;
  private $practiceAreaService;
  private $formService;
  private $newsArticleService;

  public function __construct() {
    $this->attorneyService = new AttorneyService();
    $this->practiceAreaService = new PracticeAreaService();
    $this->formService = new FormService();
    $this->newsArticleService = new NewsService();
  }

  public function showFormWithAttorney($attorney) {
    $node = $this->attorneyService->getAttorneyById($attorney);
    return [
      '#theme' => 'multisend_template_form_with_attorney',
      '#data' => [
        'form' => $this->formService
          ->getAttorneyForm($attorney),
        'attorney' => $node->getTitle(),
        'attorney_alias' => $this->attorneyService
          ->getAttorneyAlias($node->id()),
      ],
    ];
  }

  public function showFormForSinglePracticeArea($practiceAreaId) {
    $node = $this->practiceAreaService->getPracticeAreaById($practiceAreaId);
    return [
      '#theme' => 'multisend_template_form_for_practice_area',
      '#data' => [
        'form' => $this->formService
          ->getSinglePracticeAreaForm($practiceAreaId),
        'practice_area' => $node->getTitle(),
        'practice_area_alias' => $this->practiceAreaService
          ->getPracticeAreaAlias($node->id()),
      ],
    ];
  }

  public function showFormForAllPracticeAreas() {
    $nodes = $this->practiceAreaService->getAllPracticeAreas();
    return [
      '#theme' => 'multisend_template_form_for_all_practice_areas',
      '#data' => [
        'form' => $this->formService
          ->getPracticeAreasForm(),
        'practice_areas' => $nodes,
      ],
    ];
  }

  public function showFormForNewsArticle($articleId) {
    $node = $this->newsArticleService
      ->getNewsArticleById($articleId);

    return [
      '#theme' => 'multisend_template_form_for_news_article',
      '#data' => [
        'form' => $this->formService
          ->getNewsForm($node->id())
      ],
    ];

  }

}
