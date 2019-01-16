<?php
/**
 * Created by PhpStorm.
 * User: jacobstewart
 * Date: 1/12/19
 * Time: 12:52 PM
 */

namespace Drupal\multisend\Service;

use Drupal\multisend\Repository\AttorneyRepository;
use Drupal\paragraphs\Entity\Paragraph;


class AttorneyService implements AttorneyRepository
{
    private $nodeService;
    private $attorneyData;
    private $practiceAreas = [];
    private $bioTabs = [];

    public function __construct()
    {
        $this->nodeService = new NodeService();
    }

    public function getAttorneyById($id)
    {
        return $this->nodeService->getNodeById($id);
    }

    public function getAttorneyAlias($id)
    {
        return $this->nodeService->getNodeAlias($id);
    }

    private function getPracticeAreas($attorney)
    {
        $practice_areas = $attorney->get('field_practice_areas')->referencedEntities();

        foreach ($practice_areas as $practice_area)
        {
            $this->practiceAreas[] = [
                'practice_area_alias' => $this->nodeService->getNodeAlias($practice_area->id()),
                'practice_area' => $practice_area->getTitle()
            ];
        }

        return $this->practiceAreas;
    }

    private function getBioTabs($attorney)
    {
        $bio_tabs = $attorney->field_bio_tabs->referencedEntities();

        foreach ($bio_tabs as $bio_tab)
        {
            $bio_tab_values = $bio_tab->bp_accordion_section->referencedEntities();
            foreach ($bio_tab_values as $bio_tab_value)
            {
                $this->bioTabs[] = [
                    'title' => $bio_tab_value->bp_accordion_section_title->value,
                    'body' => $bio_tab_value->bp_accordion_section_body->entity->bp_text->value,
                ];
            }
        }

        return $this->bioTabs;
    }

    public function getAttorneyDataById($id)
    {
        $attorney = $this->getAttorneyById($id);

        $practice_areas = $this->getPracticeAreas($attorney);

        $bio_tabs = $this->getBioTabs($attorney);

        return [
            'name' => $attorney->getTitle(),
            'bar_admissions' => $attorney->get('field_bar_admissions')->value,
            'court_admissions' => $attorney->get('field_court_admissions')->value,
            'education' => $attorney->get('field_education')->value,
            'linkedin' => $attorney->get('field_linkedin')->value,
            'phone' => $attorney->get('field_phone')->value,
            'bio_tabs' => $bio_tabs,
            'practice_areas' => $practice_areas,
        ];
    }

    /**
     * @return mixed
     */
    public function getAttorneyData()
    {
        return $this->attorneyData;
    }

    /**
     * @param mixed $attorneyData
     */
    public function setAttorneyData($attorneyData)
    {
        $this->attorneyData = $attorneyData;
    }
}
