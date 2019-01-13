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
