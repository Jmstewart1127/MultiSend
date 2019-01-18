<?php
/**
 * Created by PhpStorm.
 * User: jacobstewart
 * Date: 1/12/19
 * Time: 12:52 PM
 */

namespace Drupal\multisend\Service;

use Drupal\multisend\Repository\AttorneyRepository;


class AttorneyService implements AttorneyRepository {

  private $nodeService;
  private $attorneyInfo = [];
  private $practiceAreas = [];
  private $bioTabs = [];

  public function __construct() {
    $this->nodeService = new NodeService();
  }

  public function getAttorneyById($id) {
    return $this->nodeService->getNodeById($id);
  }

  public function getAttorneyAlias($id) {
    return $this->nodeService->getNodeAlias($id);
  }

  private function getPracticeAreas($attorney) {
    $practice_areas = $attorney->get('field_practice_areas')->referencedEntities();
    foreach ($practice_areas as $practice_area) {
      $this->practiceAreas[] = [
        'practice_area_alias' => $this->nodeService->getNodeAlias($practice_area->id()),
        'practice_area' => $practice_area->getTitle()
      ];
    }
    return $this->practiceAreas;
  }

  private function getAttorneyInfo($attorney) {
    $info = $attorney->field_attorney_info->referencedEntities();
    foreach ($info as $item) {
      $this->attorneyInfo[] = [
        'name' => $item->field_attorney_name->value,
        'title' => $item->field_attorney_title->value,
        'image' => $item->bp_image_field->entity->getFileUri(),
      ];
    }
    return $this->attorneyInfo;
  }

  private function getBioTabs($attorney) {
    $bio_tabs = $attorney->field_bio_tabs->referencedEntities();
    foreach ($bio_tabs as $bio_tab) {
      $bio_tab_values = $bio_tab->bp_accordion_section->referencedEntities();
      foreach ($bio_tab_values as $bio_tab_value) {
        $this->bioTabs[] = [
          'title' => $bio_tab_value->bp_accordion_section_title->value,
          'body' => $bio_tab_value->bp_accordion_section_body->entity->bp_text->value,
        ];
      }
    }
    return $this->bioTabs;
  }

  public function getAttorneyDataById($id) {
    $attorney = $this->getAttorneyById($id);
    $attorney_info = $this->getAttorneyInfo($attorney);
    $practice_areas = $this->getPracticeAreas($attorney);
    $bio_tabs = $this->getBioTabs($attorney);

    return [
      'name' => $attorney_info[0]['name'],
      'title' => $attorney_info[0]['title'],
      'image' => $attorney_info[0]['image'],
      'bar_admissions' => $attorney->get('field_bar_admissions')->value,
      'court_admissions' => $attorney->get('field_court_admissions')->value,
      'education' => $attorney->get('field_education')->value,
      'linkedin' => $attorney->get('field_linkedin')->value,
      'phone' => $attorney->get('field_phone')->value,
      'bio_tabs' => $bio_tabs,
      'practice_areas' => $practice_areas,
    ];
  }

}
