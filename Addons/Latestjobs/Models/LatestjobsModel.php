<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Jobs\Addons\Latestjobs\Models;

use Kazist\KazistFactory;
use Kazist\Service\Database\Query;

class LatestjobsModel {

    public $block_id = '';

    public function getInfo() {
        return 'Hello World!';
    }

    public function getLatestJobs($limit = '') {

        $factory = new KazistFactory;

        $query = $this->getQuery();

        $query->setFirstResult(1);
        $query->setMaxResults($limit);

        $records = $query->loadObjectList();

        foreach ($records as $key => $record) {
            if ($record->job_image == '' || !file_exists(JPATH_ROOT . $record->job_image)) {
                $records[$key]->job_image = 'assets/images/briefcase.png';
            }
        }
        
        return $records;
    }

    public function getJobCategories() {

        $query = new Query();

        $query->select('jc.*, (SELECT COUNT(*) FROM #__jobs_jobs WHERE category_id = jc.id AND published=1) AS counter');
        $query->from('#__jobs_categories', 'jc');
        $query->having('counter>4');
        $query->orderBy('counter', 'DESC');


        $query->setFirstResult(0);
        $query->setMaxResults(8);

        $records = $query->loadObjectList();

        return $records;
    }

    public function getQuery($category_id = '') {
        $factory = new KazistFactory;
        $db = $factory->getDatabase();

        if (!$category_id) {
            $category_id = $factory->getSetting('job.block.latestjobs.category', $this->flexview_id);
        }

        $query = new Query();
        $query->select('jj.*,jc.title AS category_title, mm.file as job_image, uu.name as author_name');
        $query->from('#__jobs_jobs', 'jj');
        $query->leftJoin('jj', '#__jobs_categories', 'jc', 'jj.category_id = jc.id');
        $query->leftJoin('jj', '#__media_media', 'mm', 'mm.id = jj.image');
        $query->leftJoin('jj', '#__users_users', 'uu', 'uu.id = jj.created_by');

        $query->where('jj.published=1');

        if ((int) $category_id) {
            $query->andWhere('jj.category_id=' . $category_id);
        }

        // $query->where('jj.image>0');
        $query->orderBy('jj.payment_status ', 'DESC');
        $query->addOrderBy('jj.date_created ', 'DESC');

        return $query;
    }

}
