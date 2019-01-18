<?php
/**
 * Created by PhpStorm.
 * User: jacobstewart
 * Date: 1/12/19
 * Time: 2:06 PM
 */

namespace Drupal\multisend\Service;


use Drupal\node\Entity\Node;

class NodeService {

  public function getNodeById($id) {
    return Node::load((int)$id);
  }

  public function getNodeAlias($nid) {
    return \Drupal::service('path.alias_manager')
      ->getAliasByPath('/node/' . $nid);
  }

  public function buildEntityQuery($entity) {
    $query = \Drupal::entityQuery('node')
      ->condition('status', 1)
      ->condition('type', $entity);

    $nids = $query->execute();

    return \Drupal\node\Entity\Node::loadMultiple($nids);
  }

}
