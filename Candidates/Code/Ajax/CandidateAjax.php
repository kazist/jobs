<?php

/**
 * @copyright  Copyright (C) 2012 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Jobs\Candidate\Ajax;

defined('KAZIST') or exit('Not Kazist Framework');

use Jobs\Candidate\Models\CandidateModel;
use Kazist\KazistFactory;

/**
 * Dashboard Controller class for the Application
 *
 * @since  1.0
 */
class CandidateAjax {

    /**
     * Save functions
     *
     * @return  void
     *
     * @since   1.0
     * @throws  \RuntimeException
     */
    public function ajaxloadcandidates() {

        $candidateModel = new CandidateModel();
        echo $candidateModel->loadCandidateDocuments();
        exit;
    }

    public function ajaxdeletedocument() {
        $candidateModel = new CandidateModel();
        $factory = new KazistFactory();
        $input = $factory->getInput();

        $document_id = $this->request->request->get('document_id');

        echo $candidateModel->deleteDocument($document_id);
        exit;
    }

}
