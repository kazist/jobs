<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Jobs\Addons\Menujob\Controllers;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\KazistFactory;
use Kazist\Controller\AddonController;
use Jobs\Addons\Menujob\Models\MenujobModel;

/**
 * Kazist view class for the application
 *
 * @since  1.0
 */
class MenujobController extends AddonController {

    function indexAction($offset = 0, $limit = 6) {

        $factory = new KazistFactory;
        $model = new MenujobModel;

        $jobs = $model->getJobs();

        $data_arr['jobs'] = $jobs;

        $this->html = $this->render('Jobs:Addons:Menujob:views:menujob.twig', $data_arr);

        $response = $this->response($this->html);

        return $response;
    }

}
