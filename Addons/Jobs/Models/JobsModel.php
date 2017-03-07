<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Jobs\Addons\Jobs\Models;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\KazistFactory;

class JobsModel {

    public function getInfo() {
        return 'Hello World!';
    }

    public function getJobs() {


        $query = $this->getQuery();

        $query->setFirstResult(0);
        $query->setMaxResults(5);

        $records = $query->loadObjectList();


        return $records;
    }

    public function getQuery() {

        $factory = new KazistFactory();

        $query = $factory->getQueryBuilder('#__jobs_jobs', 'jj');

        $query->where('jj.published=1');
        $query->orderBy('jj.payment_status', 'DESC');
        $query->addOrderBy('jj.date_created', 'DESC');

        return $query;
    }

}
