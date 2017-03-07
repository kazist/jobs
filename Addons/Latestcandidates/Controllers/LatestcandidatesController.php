<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Jobs\Addons\Latestcandidates\Controllers;

use Kazist\Controller\AddonController;
use Jobs\Addons\Latestcandidates\Models\LatestcandidatesModel;

/**
 * Kazist view class for the application
 *
 * @since  1.0
 */
class LatestcandidatesController extends AddonController {

    function indexAction($offset = 0, $limit = 6) {

        $model = new LatestcandidatesModel;

        $jobcandidates = $model->getJobCandidate();

        $data_arr['jobcandidates'] = $jobcandidates;

        $this->html = $this->render('Jobs:Addons:Latestcandidates:views:latestcandidates.twig', $data_arr);

        $response = $this->response($this->html);



        return $response;
    }

}
