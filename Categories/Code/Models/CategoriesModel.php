<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Jobs\Categories\Code\Models;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\Model\BaseModel;
use Kazist\KazistFactory;
use Kazist\Service\Database\Query;

/**
 * Description of MarketplaceModel
 *
 * @author sbc
 */
class CategoriesModel extends BaseModel {

    public function getCategories($parent_id = '') {

        $factory = new KazistFactory();

        $session = $factory->getSession();

        //$email->debug_exit = true;
        $uri = $session->get('uri');

        $query = new Query();
        $query->select('jc.*');
        $query->from('#__jobs_categories', 'jc');

        if ($parent_id) {
            $query->where('parent_id=:parent_id');
            $query->setParameter('parent_id', $parent_id);
        } else {
            $query->where('parent_id IS NULL OR parent_id=0');
        }
        $query->orderBy('id ', 'DESC');



        $records = $query->loadObjectList();

        if (!empty($records)) {
            foreach ($records as $key => $record) {
                $records[$key]->children = $this->getCategories($record->id);
                $records[$key]->total_jobs = $this->getCategoryJobTotal($record->id);
            }
        }


        return $records;
    }

    public function getCategory($category_id) {

        $factory = new KazistFactory();

        $session = $factory->getSession();

        //$email->debug_exit = true;
        $uri = $session->get('uri');

        $query = new Query();
        $query->select('jc.*');
        $query->from('#__jobs_categories', 'jc');
        $query->where('id=:id');
        $query->setParameter('id', $category_id);
        $query->orderBy('id ', 'DESC');



        $record = $query->loadObject();

        return $record;
    }

    public function getCategoryJobTotal($category_id) {

        $factory = new KazistFactory();

        $session = $factory->getSession();

        //$email->debug_exit = true;
        $uri = $session->get('uri');

        $query = new Query();
        $query->select('Count(*) AS total');
        $query->from('#__jobs_jobs', 'jj');
        $query->where('category_id=:category_id');
        $query->setParameter('category_id', $category_id);



        $record = $query->loadObject();

        return $record->total;
    }

}
