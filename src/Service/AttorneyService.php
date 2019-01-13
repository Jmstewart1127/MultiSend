<?php
/**
 * Created by PhpStorm.
 * User: jacobstewart
 * Date: 1/12/19
 * Time: 12:52 PM
 */

namespace Drupal\multisend\Service;

use Drupal\multisend\Repository\AttorneyRepository;


class AttorneyService implements AttorneyRepository
{
    private $nodeService;
    private $attorneyData;
    private $practiceAreas = [];

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

    public function getAttorneyDataById($id)
    {
        $attorney = $this->getAttorneyById($id);

        $practice_areas = $this->getPracticeAreas($attorney);

        return [
            'name' => $attorney->getTitle(),
            'bar_admissions' => $attorney->get('field_bar_admissions')->value,
            'court_admissions' => $attorney->get('field_court_admissions')->value,
            'education' => $attorney->get('field_education')->value,
            'linkedin' => $attorney->get('field_linkedin')->value,
            'phone' => $attorney->get('field_phone')->value,
            'practice_areas' => $practice_areas
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
