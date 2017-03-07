<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Jobs\Addons\Category\Models;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\KazistFactory;
use Kazist\Service\Database\Query;

class CategoryModel {

    public function getInfo() {
        return 'Hello World!';
    }

    public function getDefaultCategory($categories) {
        return $categories[0]->id;
    }

    public function getJobCategory($parent_id = '') {

        $query = $this->getQuery($parent_id);

        $records = $query->loadObjectList();

        if (!empty($records)) {
            foreach ($records as $key => $record) {
                $records[$key]->children = $this->getJobCategory($record->id);
            }
        }


        return $records;
    }

    public function getQuery($parent_id) {

        $query = new Query();

        $query->select('jc.*');
        $query->from('#__jobs_categories', 'jc');
        $query->where('jc.published=1');
        if ($parent_id) {
            $query->andWhere('jc.parent_id = :parent_id');
            $query->setParameter('parent_id', $parent_id);
        } else {
            $query->andWhere('jc.parent_id IS NULL OR parent_id=0');
        }
        $query->orderBy('jc.title');

        return $query;
    }

}
