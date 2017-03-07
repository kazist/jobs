<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Jobs\Addons\Jobs\Controllers;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\Controller\AddonController;
use Jobs\Addons\Jobs\Models\JobsModel;

/**
 * Kazist view class for the application
 *
 * @since  1.0
 */
class JobsController extends AddonController {

    function indexAction($offset = 0, $limit = 6) {

        $model = new JobsModel;

        $jobs = $model->getJobs();

        $data_arr['jobs'] = $jobs;

        $this->html = $this->render('Jobs:Addons:Jobs:views:jobs.twig', $data_arr);

        $response = $this->response($this->html);

        return $response;
    }

}
