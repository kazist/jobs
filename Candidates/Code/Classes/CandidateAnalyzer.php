<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Jobs\Candidate\Classes;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\KazistFactory;
use Kazist\Service\Database\Query;

/**
 * Description of AdvertController
 *
 * @author sbc
 */
class CandidateAnalyzer {

    public function processCandidateAnalyzer() {

        $candidates = $this->getCandidates();

        if (!empty($candidates)) {
            foreach ($candidates as $key => $candidate) {
                $this->updateCandidateImageFromUser($candidate);
            }
        }
    }

    public function getCandidates() {

        $factory = new KazistFactory();


        $query = new Query();
        $query->select('jc.*');
        $query->from('#__jobs_candidates', 'jc');
        $query->where('(jc.avatar<1 OR jc.avatar IS NULL)');

        $query->setFirstResult(0);
        $query->setMaxResults(10);

        $records = $query->loadObjectList();

        return $records;
    }

    public function updateCandidateImageFromUser($candidate) {

        $factory = new KazistFactory();
        $user = $factory->getQueryBuilder('#__users_users', 'uu', array('id=:id'), array('id' => $candidate->created_by));


        $data_obj = new \stdClass();
        $data_obj->id = $candidate->id;
        $data_obj->avatar = $user->avatar;

        $factory->saveRecord('#__jobs_candidates', $data_obj);
    }

}
