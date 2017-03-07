<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Jobs\Addons\Latestjobs\Controllers;

use Kazist\KazistFactory;
use Kazist\Controller\AddonController;
use Jobs\Addons\Latestjobs\Models\LatestjobsModel;

/**
 * Kazist view class for the application
 *
 * @since  1.0
 */
class LatestjobsController extends AddonController {

    public $flexview_id = '';

    function indexAction($show_categories = 1, $limit = 8) {

        $factory = new KazistFactory;
        $model = new LatestjobsModel;

        $show_categories = $factory->getSetting('job.block.latestjobs.show.category', $this->flexview_id);
        $model->flexview_id = $this->flexview_id;

        $categories = $model->getJobCategories();
        $jobs = $model->getLatestJobs($limit);

        $data_arr['categories'] = $categories;
        $data_arr['jobs'] = $jobs;
        $data_arr['show_categories'] = $show_categories;



        $this->html = $this->render('Jobs:Addons:Latestjobs:views:latestjobs.twig', $data_arr);

        $response = $this->response($this->html);



        return $response;
    }

}
