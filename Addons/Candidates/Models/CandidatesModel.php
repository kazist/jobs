<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Jobs\Addons\Candidates\Models;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\KazistFactory;
use Kazist\Service\Database\Query;

class CandidatesModel {

    public function getInfo() {
        return 'Hello World!';
    }

    public function getJobCandidate() {
        $factory = new KazistFactory;

        $query = $this->getQuery();

        $query->setFirstResult(0);
        $query->setMaxResults(5);

        $records = $query->loadObjectList();


        return $records;
    }

    public function getQuery() {
        $factory = new KazistFactory;

        $query = $factory->getQueryBuilder('#__jobs_candidates', 'jc');

        $query->where('jc.published=1');
        $query->orderBy('jc.payment_status');
        $query->addOrderBy('jc.date_created ', 'DESC');

        return $query;
    }

}
