<?php
/**
 * Created by PhpStorm.
 * User: jacobstewart
 * Date: 1/12/19
 * Time: 1:50 PM
 */

namespace Drupal\multisend\Repository;


interface PracticeAreaRepository {

    public function getPracticeAreaById($id);
    public function getSinglePracticeAreaDataById($id);
    public function getAllPracticeAreas();

}
