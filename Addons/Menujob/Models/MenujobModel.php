<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Jobs\Addons\Menujob\Models;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\KazistFactory;
use Jobs\Jobs\Code\Models\JobsModel;

class MenujobModel {

    public function getInfo() {
        return 'Hello World!';
    }

    public function getJobs() {

        $factory = new KazistFactory();
        $jobModel = new JobsModel();

        $query = $factory->getQueryBuilder('#__jobs_jobs', 'jj');

        $query->where('jj.published=1');
        $query->having('image_file<>\'\'');
        $query->orderBy('jj.payment_status', '', 'DESC');
        $query->addOrderBy('jj.date_created', '', 'DESC');

        $query->setFirstResult(0);
        $query->setMaxResults(4);

        $records = $query->loadObjectList();
        $records = $jobModel->getAdditionalDetail($records);

        return $records;
    }

}
