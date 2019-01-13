<?php
/**
 * Created by PhpStorm.
 * User: jacobstewart
 * Date: 1/12/19
 * Time: 1:51 PM
 */

namespace Drupal\multisend\Service;


use Drupal\multisend\Repository\PracticeAreaRepository;

class PracticeAreaService implements PracticeAreaRepository
{
    private $nodeService;

    public function __construct()
    {
        $this->nodeService = new NodeService();
    }

    public function getPracticeAreaById($id)
    {
        return $this->nodeService->getNodeById($id);
    }

    private function getChairs($practice_area)
    {
        $chairs = $practice_area->get('field_chairs_ref')->referencedEntities();

        $store_chairs = [];

        foreach ($chairs as $chair)
        {
            $store_chairs[] = [
                'chair_name' => $chair->getTitle(),
                'chair_alias' => $this->nodeService->getNodeAlias($chair->id())
            ];
        }

        return $store_chairs;
    }

    private function getMembersOfPractice($practice_area)
    {
        $members = $practice_area->get('field_members2')->referencedEntities();

        $store_members = [];

        foreach ($members as $member)
        {
            $store_members[] = [
                'member_name' => $member->getTitle(),
                'member_alias' => $this->nodeService->getNodeAlias($member->id())
            ];
        }

        return $store_members;
    }

    public function getSinglePracticeAreaDataById($id)
    {
        $practice_area = $this->getPracticeAreaById($id);

        $chairs = $this->getChairs($practice_area);

        $members_of_practice = $this->getMembersOfPractice($practice_area);

        return [
            'practice_area_name' => $practice_area->getTitle(),
            'practice_area_chairs' => $chairs,
            'practice_area_members' => $members_of_practice
        ];
    }

    public function getAllPracticeAreas()
    {
        $nodes = $this->nodeService->buildEntityQuery('practice_areas');

        $practice_areas = [];

        foreach ($nodes as $node)
        {
            $practice_areas[] = [
                'title' => $node->getTitle(),
                'alias' => $this->nodeService->getNodeAlias($node->id())
            ];
        }

        return $practice_areas;
    }
}
