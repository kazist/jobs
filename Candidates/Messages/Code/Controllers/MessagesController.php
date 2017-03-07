<?php

/*
 * This file is part of Kazist Framework.
 * (c) Dedan Irungu <irungudedan@gmail.com>
 *  For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 * 
 */

/**
 * Description of MessagesController
 *
 * @author sbc
 */

namespace Jobs\Candidates\Messages\Code\Controllers;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\KazistFactory;
use Kazist\Controller\BaseController;

class MessagesController extends BaseController {

    public function addAction($id = '') {

        $factory = new KazistFactory();

        $candidate_id = $this->request->get('candidate_id');

        $this->data_arr['candidate'] = $factory->getRecord('#__jobs_candidates', 'jc', array('jc.id=:id'), array('id' => $candidate_id));

        return parent::addAction($id);
    }

    public function editAction($id = '') {

        return $this->redirectToRoute('jobs.candidates.messages');
    }

}
