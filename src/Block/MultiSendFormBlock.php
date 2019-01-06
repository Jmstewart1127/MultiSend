<?php

use Drupal\Core\Block\BlockBase;

/**
 * Created by PhpStorm.
 * User: jacobstewart
 * Date: 1/5/19
 * Time: 3:40 PM
 */

class MultiSendFormBlock extends BlockBase
{

    /**
     * Builds and returns the renderable array for this block plugin.
     *
     * If a block should not be rendered because it has no content, then this
     * method must also ensure to return no content: it must then only return an
     * empty array, or an empty array with #cache set (with cacheability metadata
     * indicating the circumstances for it being empty).
     *
     * @return array
     *   A renderable array representing the content of the block.
     *
     * @see \Drupal\block\BlockViewBuilder
     */
    public function build()
    {
        // TODO: Implement build() method.
    }
}
