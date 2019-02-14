<?php
/**
 * Created by PhpStorm.
 * User: jacobstewart
 * Date: 2/13/19
 * Time: 8:15 PM
 */

namespace Drupal\multisend\Service;


class NewsService {

  private $nodeService;

  public function __construct() {
    $this->nodeService = new NodeService();
  }

  public function getNewsArticleById($id) {
    return $this->nodeService->getNodeById($id);
  }

  public function getNewsArticleAlias($id) {
    return $this->nodeService->getNodeAlias($id);
  }

  public function getNewsArticleInfoById($id) {
    $article = $this->nodeService->getNodeById($id);
    $tags = $article->field_tags->referencedEntities();

    return [
      'title' => $article->getTitle(),
      'body' => $article->body->value,
    ];
  }

}
