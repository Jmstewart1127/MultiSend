<?php
/**
 * Created by PhpStorm.
 * User: jacobstewart
 * Date: 1/12/19
 * Time: 12:52 PM
 */

namespace Drupal\multisend\Repository;

interface AttorneyRepository
{
    public function getAttorneyById($id);

    public function getAttorneyDataById($id);
}
