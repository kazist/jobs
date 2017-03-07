<?php

/*
 * This file is part of Kazist Framework.
 * (c) Dedan Irungu <irungudedan@gmail.com>
 *  For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 * 
 */

/**
 * Description of CandidatesContoller
 *
 * @author sbc
 */

namespace Jobs\Candidates\Code\Controllers;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\Controller\BaseController;
use Jobs\Candidates\Code\Models\CandidatesModel;
use Kazist\KazistFactory;

class CandidatesController extends BaseController {

    public function indexAction() {

        $this->twig_paths[] = JPATH_ROOT . '/applications/Jobs/generalviews/';

        $this->model = new CandidatesModel();

        $items = $this->model->getRecords();
        $items = $this->model->getAdditionalDetail($items);

        $data_arr['items'] = $items;

        $this->html = $this->render('Jobs:Candidates:Code:views:table.index.twig', $data_arr);

        $response = $this->response($this->html);



        return $response;
    }

    public function detailAction($id = '') {

        $this->twig_paths[] = JPATH_ROOT . '/applications/Jobs/generalviews/';


        $this->model = new CandidatesModel();
        $packages = $this->model->getPackages(true);
        $item = $this->model->getRecord($id);
        $item = $this->model->getItemAdditionDetails($item);

        $data_arr['item'] = $item;
        $data_arr['packages'] = $packages;

        $this->html = $this->render('Jobs:Candidates:Code:views:detail.index.twig', $data_arr);

        $response = $this->response($this->html);

        return $response;
    }

    public function addAction() {

        $this->twig_paths[] = JPATH_ROOT . '/applications/Jobs/generalviews/';

        $this->model = new CandidatesModel();

        $candidate = $this->model->getCurrentCandidate();

        if ($candidate->id) {
            return $this->redirectToRoute('jobs.candidates.edit', array('id' => $candidate->id));
        }

        $item = $this->model->getRecord();
        $packages = $this->model->getPackages(true);
        $item = $this->model->getItemAdditionDetails($item);
        $certifications = $this->model->getCertifications();
        $countries = $this->model->getCountries();
        $locations = $this->model->getLocations($item->country_id);

        $data_arr['item'] = $item;
        $data_arr['packages'] = $packages;
        $data_arr['certifications'] = $certifications;
        $data_arr['countries'] = $countries;
        $data_arr['locations'] = $locations;

        $this->html = $this->render('Jobs:Candidates:Code:views:edit.index.twig', $data_arr);

        $response = $this->response($this->html);



        return $response;
    }

    public function editAction($id = '') {

        $this->twig_paths[] = JPATH_ROOT . '/applications/Jobs/generalviews/';

        $this->model = new CandidatesModel();


        $item = $this->model->getRecord($id);
        $item = $this->model->getItemAdditionDetails($item);
        $certifications = $education_options = $this->model->getCertifications();
        $countries = $this->model->getCountries();
        $packages = $this->model->getPackages(true);
        $documents = $this->model->getDocuments($item->id);
        $educations = $this->model->getEducations($item->id);
        $locations = $this->model->getLocations($item->country_id);

        $data_arr['item'] = $item;
        $data_arr['packages'] = $packages;
        $data_arr['certifications'] = $certifications;
        $data_arr['education_options'] = $education_options;
        $data_arr['countries'] = $countries;
        $data_arr['locations'] = $locations;
        $data_arr['documents'] = $documents;
        $data_arr['educations'] = $educations;

        $this->html = $this->render('Jobs:Candidates:Code:views:edit.index.twig', $data_arr);

        $response = $this->response($this->html);



        return $response;
    }

    public function saveexperienceAction() {

        $this->model = new CandidatesModel();

        $redirect = '';

        $factory = new KazistFactory();

        $user = $factory->getUser();

        if ($user->id) {

            $form = $this->request->request->get('form', null, 'raw');

            $return_url = $this->model->saveExperiences($form);

            $redirect = $return_url;
        } else {
            $redirect = $this->generateUrl('login');
        }

        return $this->redirect($redirect);
    }

    public function saveeducationAction() {

        $this->model = new CandidatesModel();

        $redirect = '';

        $factory = new KazistFactory();

        $user = $factory->getUser();

        if ($user->id) {

            $form = $this->request->request->get('form', null, 'raw');

            $return_url = $this->model->saveEducations($form);

            $redirect = $return_url;
        } else {
            $redirect = $this->generateUrl('login');
        }

        return $this->redirect($redirect);
    }

    public function deleteexperienceAction() {

        $this->model = new CandidatesModel();

        $redirect = '';

        $factory = new KazistFactory();

        $user = $factory->getUser();

        if ($user->id) {

            $experience_id = $this->request->request->get('experience_id');
            $candidate_id = $this->request->request->get('candidate_id');

            $this->model->deleteExperiences($experience_id);

            $return_url = $this->generateUrl('jobs.candidates.edit', array('id', $candidate_id));

            $redirect = $return_url;
        } else {
            $redirect = $this->generateUrl('login');
        }

        return $this->redirect($redirect);
    }

    public function deleteeducationAction() {

        $this->model = new CandidatesModel();

        $redirect = '';

        $factory = new KazistFactory();

        $user = $factory->getUser();

        $base_url = WEB_ROOT;

        if ($user->id) {


            $education_id = $this->request->request->get('education_id');
            $candidate_id = $this->request->request->get('candidate_id');

            $this->model->deleteEducations($education_id);

            $return_url = $this->generateUrl('job.candidate.candidate.edit&id=' . $candidate_id);

            $redirect = $return_url;
        } else {
            $redirect = $this->generateUrl('login');
        }

        return $this->redirect($redirect);
    }

    public function saveAction($form_data = '') {

        if (WEB_IS_ADMIN) {
            return parent::saveAction($form_data);
        } else {

            $form_data = $this->request->request->get('form');

            $id = $this->model->save($form_data);

            if ($this->model->redirect <> '') {
                return $this->redirect($this->model->redirect);
            } else {
                return $this->redirectToRoute('jobs.canditates.detail', array('id' => $id));
            }
        }
    }

    public function croncandidateanalyzerAction() {

        $this->model = new CandidatesModel();
        $this->model->processCandidateAnalyzer();
    }

}
