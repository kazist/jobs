<?php

/**
 * @copyright  Copyright (C) 2012 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Jobs\Jobs\Ajax;

defined('KAZIST') or exit('Not Kazist Framework');

use Jobs\Jobs\Models\JobModel;
use Kazist\KazistFactory;

/**
 * Dashboard Controller class for the Application
 *
 * @since  1.0
 */
class JobAjax {

    /**
     * Save functions
     *
     * @return  void
     *
     * @since   1.0
     * @throws  \RuntimeException
     */
    public function ajaxloadjobs() {

        $jobModel = new JobModel();
        echo $jobModel->loadCategoryJobs();
        exit;
    }

    public function ajaxloadlocations() {

        $jobModel = new JobModel();
        echo $jobModel->loadCountryLocations();
        exit;
    }

    public function ajaxloadcategoryjobs() {

        $jobModel = new JobModel();
        echo $jobModel->loadBlockCategoryJobs();
        exit;
    }

}
