<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Jobs\Addons\Candidates\Controllers;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\Controller\AddonController;
use Jobs\Addons\Candidates\Models\CandidatesModel;

/**
 * Kazist view class for the application
 *
 * @since  1.0
 */
class CandidatesController extends AddonController {

    function indexAction($offset = 0, $limit = 6) {

        $model = new CandidatesModel;

        $candidates = $model->getJobCandidate();

        $data_arr['candidates'] = $candidates;

        $this->html = $this->render('Jobs:Addons:Candidates:views:candidates.twig', $data_arr);

        $response = $this->response($this->html);



        return $response;
    }

}
