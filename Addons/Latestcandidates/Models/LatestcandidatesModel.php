<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Jobs\Addons\Latestcandidates\Models;

use Kazist\KazistFactory;
use Kazist\Service\Database\Query;

class LatestcandidatesModel {

    public function getInfo() {
        return 'Hello World!';
    }

    public function getJobCandidate() {

        $query = $this->getQuery();

        $query->setFirstResult(0);
        $query->setMaxResults(8);

        $records = $query->loadObjectList();
        return $records;
    }

    public function getQuery() {

        $query = new Query();

        $query->select('jc.*, mm.file as avatar_image, swc.name as country_name, uu.name as user_name');
        $query->from('#__jobs_candidates', 'jc');
        $query->leftJoin('jc', '#__media_media', 'mm', 'mm.id = jc.avatar');
        $query->leftJoin('jc', '#__setup_countries', 'swc', 'swc.id = jc.country_id');
        $query->leftJoin('jc', '#__users_users', 'uu', 'uu.id = jc.user_id');
        $query->where('jc.published=1');
        //$query->where('jc.avatar>1');
        $query->orderBy('jc.payment_status', 'DESC');
        $query->addOrderBy('jc.date_created', 'DESC');

        return $query;
    }

}
