<?php

/*
 * This file is part of Kazist Framework.
 * (c) Dedan Irungu <irungudedan@gmail.com>
 *  For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 * 
 */

/**
 * Description of ApplicationsController
 *
 * @author sbc
 */

namespace Jobs\Jobs\Applications\Code\Controllers;

defined('KAZIST') or exit('Not Kazist Framework');

use Jobs\Jobs\Applications\Code\Models\ApplicationsModel;
use Kazist\KazistFactory;
use Kazist\Controller\BaseController;

class ApplicationsController extends BaseController {

    public function addAction($id = '') {

        $factory = new KazistFactory();

        $job_id = $this->request->get('job_id');

        $this->data_arr['job'] = $factory->getRecord('#__jobs_jobs', 'jj', array('jj.id=:id'), array('id' => $job_id));

        return parent::addAction($id);
    }

    public function editAction($id = '') {

        return $this->redirectToRoute('jobs.jobs.applications');
    }

}
