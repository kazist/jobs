<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Jobs\Candidates\Code\Models;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\Model\BaseModel;
use Kazist\KazistFactory;
use Jobs\Jobs\Code\Models\JobsModel;
use Jobs\Candidates\Code\Classes\CandidateAnalyzer;
use Kazist\Service\Database\Query;

/**
 * Description of MarketplaceModel
 *
 * @author sbc
 */
class CandidatesModel extends BaseModel {

    public $redirect = '';

    public function appendSearchQuery($query) {

        $factory = new KazistFactory();

        $package_id = $this->request->request->get('package_id');
        $category_id = $this->request->request->get('category_id');

        $query->where('1=1');

        if ($package_id) {
            $query->andWhere('jc.package_id=' . $package_id);
        }
        if ($category_id) {
            $query->andWhere('jc.category_id=' . $category_id);
        }


        $query->orderBy('jc.payment_status', 'DESC');
        $query->orderBy('jc.date_created', 'DESC');

        return $query;
    }

    public function save($form = '') {

        $document = $this->container->get('document');

        $factory = new KazistFactory();
        $user = $factory->getUser();

        $user_id = $user->id;

        $default_gateway = $factory->getSetting('finance_gateway_default_gateway');

        $form['user_id'] = ( $form['user_id']) ? $form['user_id'] : $user_id;

        $id = parent::save($form);

        if ($id) {
            $candidate = $this->getCandidate($id);
            $package_price = $this->getPackagePrice($candidate->package_price_id);

            $candidate->payment_amount = $package_price->price;
            $msg = 'Candidate Save Successfully.';

            $factory->saveRecord('#__jobs_candidates', $candidate);

            if ($form['new_payment'] || ($candidate->payment_amount && !$candidate->payment_status)) {
                $msg .= ' Proceed With Payment.';
                $factory->enqueueMessage($msg, 'info');
                $this->redirect = $this->generateUrl('finance.payments.newpayment', array(
                    'path' => 'jobs.candidates',
                    'gateway_id' => $default_gateway,
                    'pay_subset_id' => $document->subset_id,
                    'amount' => $candidate->payment_amount,
                    'item_id' => $candidate->id,
                    'description' => 'Advert: ' . $form['title']
                ));
            } else {
                $factory->enqueueMessage($msg, 'info');
                $this->redirect = $this->generateUrl('jobs.candidates.detail', array('id' => $id));
            }

            $this->saveResume($id, $form);
            $this->saveImages($id, $form);
            $this->saveDocuments($id, $form, 'new');
            $this->saveDocuments($id, $form, 'exist');
            $this->saveCategories($id, $form);
            $this->saveSkills($id, $form);
        } else {

            $msg = 'Saving Candidate Failed.';
            $factory->enqueueMessage($msg, 'info');
            $this->redirect = $this->generateUrl('jobs.candidates.edit');
        }

        return $id;
    }

    public function saveCategories($candidate_id, $form) {

        $factory = new KazistFactory();

        if (!empty($form['category'])) {
            foreach ($form['category'] as $category) {
                $data_obj = new \stdClass();
                $data_obj->candidate_id = $candidate_id;
                $data_obj->category_id = $category;

                $factory->saveRecord('#__jobs_candidates_categories', $data_obj);
            }
        }
    }

    public function saveDocuments($candidate_id, $form, $action) {

        $data_obj = new \stdClass();
        $factory = new KazistFactory();

        if ($action == 'new') {

            $media_ids = $factory->uploadMedia('form.document.new.upload', 'jobs.candidates', $candidate_id);

            if (!empty($media_ids)) {
                foreach ($media_ids as $key => $media_id) {

                    if ($media_id) {
                        $data_obj = new \stdClass();
                        $existing_obj = new \stdClass();

                        $existing_obj->id = $media_id;
                        $existing_obj->title = $form['document']['new']['title'][$key];

                        $data_obj->candidate_id = $candidate_id;
                        $data_obj->document = $media_id;

                        $where_arr = array('candidate_id=:candidate_id', 'document=:document');
                        $parameter_arr = (array) $data_obj;

                        $factory->saveRecord('#__jobs_candidates_documents', $data_obj, $where_arr, $parameter_arr);
                        $factory->saveRecord('#__media_media', $existing_obj);
                    }
                }
            }
        } else {

            if (!empty($form['document']['exist']['media_id'])) {
                foreach ($form['document']['exist']['media_id'] as $key => $media_id) {

                    $existing_obj = new \stdClass();

                    $existing_obj->id = $media_id;
                    $existing_obj->title = $form['document']['exist']['title'][$key];

                    $factory->saveRecord('#__media_media', $existing_obj);
                }
            }
        }
    }

    public function saveEducations($form) {

        $factory = new KazistFactory();

        $data_obj = new \stdClass();

        if ($form['education']['id']) {
            $data_obj->id = $form['education']['id'];
        }

        $data_obj->candidate_id = $form['education']['candidate_id'];
        $data_obj->institution = $form['education']['institution'];
        $data_obj->certification_id = $form['education']['certification_id'];
        $data_obj->field_of_study = $form['education']['field_of_study'];
        $data_obj->grade = $form['education']['grade'];
        $data_obj->activities = $form['education']['activities'];
        $data_obj->description = $form['education']['description'];
        $data_obj->start_date = $form['education']['start_date'];
        $data_obj->end_date = $form['education']['end_date'];

        $factory->saveRecord('#__jobs_candidates_education', $data_obj);

        $redirect = $this->generateUrl('jobs.candidates.edit', array('id' => $data_obj->candidate_id));

        return $redirect;
    }

    public function saveExperiences($form) {

        $factory = new KazistFactory();
        $data_obj = new \stdClass();

        if ($form['experience']['id']) {
            $data_obj->id = $form['experience']['id'];
        }

        $data_obj->candidate_id = $form['experience']['candidate_id'];
        $data_obj->title = $form['experience']['title'];
        $data_obj->description = $form['experience']['description'];
        $data_obj->company = $form['experience']['company'];
        $data_obj->location = $form['experience']['location'];
        $data_obj->position = $form['experience']['position'];
        $data_obj->start_date = $form['experience']['start_date'];
        $data_obj->end_date = $form['experience']['end_date'];

        $factory->saveRecord('#__jobs_candidates_experiences', $data_obj);

        $redirect = $this->generateUrl('jobs.candidates.edit', array('id' => $data_obj->candidate_id));

        return $redirect;
    }

    public function saveSkills($candidate_id, $form) {

        $candidate_skills_arr = array();
        $factory = new KazistFactory();

        $skills = explode(',', $form['skills']);


        if (!empty($skills)) {
            foreach ($skills as $skill) {
                if ($skill <> '') {

                    $skill_obj = new \stdClass();
                    $skill_obj->skill = $skill;
                    $skill_id = $factory->saveRecord('#__jobs_skills', $skill_obj, array('js.skill=:skill'), $skill_obj);

                    $candidate_skill_obj = new \stdClass();
                    $candidate_skill_obj->candidate_id = $candidate_id;
                    $candidate_skill_obj->skill_id = $skill_id;

                    $where_arr = array('candidate_id=:candidate_id', 'skill_id=:skill_id');
                    $parameter_arr = (array) $candidate_skill_obj;

                    $candidate_skill_id = $factory->saveRecord('#__jobs_candidates_skills', $candidate_skill_obj, $where_arr, $parameter_arr);
                    $candidate_skills_arr[] = $candidate_skill_id;
                }
            }
        }

        $query = new Query();
        $query->delete('#__jobs_candidates_skills');
        $query->where('1=1');

        if (!empty($candidate_skills_arr)) {
            $query->andWhere('id NOT IN (:candidate_id)');
            $query->setParameter('candidate_id', implode(',', $candidate_skills_arr));
        } else {
            $query->andWhere('candidate_id=' . $candidate_id);
            $query->setParameter('candidate_id', (int) $candidate_id);
        }

        $query->execute();
    }

    public function saveImages($candidate_id, $form) {

        $data_obj = new \stdClass();
        $factory = new KazistFactory();

        $media_ids = $factory->uploadMedia('form.avatar', 'jobs.candidates', $candidate_id);

        $data_obj->id = $candidate_id;
        $data_obj->avatar = (count($media_ids)) ? $media_ids[0] : 0;

        if ($data_obj->avatar) {
            $factory->saveRecord('#__jobs_candidates', $data_obj);
        }
    }

    public function saveResume($candidate_id, $form) {

        $existing_obj = new \stdClass();
        $data_obj = new \stdClass();
        $factory = new KazistFactory();

        $media_ids = $factory->uploadMedia('form.image', 'jobs.candidates', $candidate_id);

        $data_obj->id = $candidate_id;
        $data_obj->image = (count($media_ids)) ? $media_ids[0] : 0;

        if ($data_obj->image) {
            $factory->saveRecord('#__jobs_candidates', $data_obj);
        }
    }

    //put your code here
    public function getAdditionalDetail($items) {

        $tmp_array = array();

        if (!empty($items)) {
            foreach ($items as $item) {
                $tmp_array[] = $this->getItemAdditionDetails($item);
            }
        }

        return $tmp_array;
    }

    public function getItemAdditionDetails($item) {

        $factory = new KazistFactory();
        $item_obj = (is_object($item)) ? $item : new \stdClass();

        $item_obj->title = ucwords($item->title);
        $item_obj->country = $this->getCountryName($item->country_id);
        $item_obj->location = $this->getLocationName($item->location_id);

        return $item_obj;
    }

    public function getCurrentCandidate() {

        $factory = new KazistFactory();

        $session = $factory->getSession();
        $user = $factory->getUser();

        $query = new Query();
        $query->select('jc.*');
        $query->from('#__jobs_candidates', 'jc');
        $query->where('jc.user_id=:user_id');
        $query->setParameter('user_id', (int) $user->id);
        $query->orderBy('jc.id ', 'DESC');

        $record = $query->loadObject();

        return $record;
    }

    public function getCandidate($candidate_id) {

        $factory = new KazistFactory();

        $session = $factory->getSession();

        //$email->debug_exit = true;
        $uri = $session->get('uri');

        $query = new Query();
        $query->select('jc.*');
        $query->from('#__jobs_candidates', 'jc');
        $query->where('jc.id=:candidate_id');
        $query->setParameter('candidate_id', (int) $candidate_id);
        $query->orderBy('jc.id ', 'DESC');

        $record = $query->loadObject();

        return $record;
    }

    public function getLocationName($location_id) {

        $factory = new KazistFactory();


        $query = new Query();
        $query->select('swr.*');
        $query->from('#__setup_regions', 'swr');
        if ($location_id) {
            $query->where('swr.id=' . $location_id);
            $query->setParameter('location_id', (int) $location_id);
        } else {
            $query->where('1=-1');
        }


        $record = $query->loadObject();

        return $record;
    }

    public function getCountryName($country_id) {

        $factory = new KazistFactory();


        $query = new Query();
        $query->select('swc.*');
        $query->from('#__setup_countries', 'swc');
        if ($country_id) {
            $query->where('swc.id=' . $country_id);
            $query->setParameter('country_id', (int) $country_id);
        } else {
            $query->where('1=-1');
        }


        $record = $query->loadObject();

        return $record;
    }

    public function getCategoriesInput() {

        $jobModel = new JobsModel();
        $categories = $jobModel->getCategories();
        $user_categories = $this->getUserCategoriesInput();

        if (!empty($categories)) {
            foreach ($categories as $key1 => $category) {
                if (!empty($category->children)) {
                    foreach ($category->children as $key2 => $child) {
                        if (in_array($child->id, $user_categories)) {
                            $categories[$key1]->children[$key2]->is_selected = 1;
                        } else {
                            $categories[$key1]->children[$key2]->is_selected = 0;
                        }
                    }
                }
            }
        }

        return $categories;
    }

    public function getUserCategories() {

        $factory = new KazistFactory();


        $query = new Query();
        $query->select('jcc.*');
        $query->from('#__jobs_candidates_categories', 'jcc');



        $record = $query->loadObjectList();

        return $record;
    }

    public function getUserCategoriesInput() {

        $data_arr = array();

        $user_categories = $this->getUserCategories();

        if (!empty($user_categories)) {
            foreach ($user_categories as $user_category) {
                $data_arr[] = $user_category->category_id;
            }
        }

        return $data_arr;
    }

    public function getPackages($fetch_prices = false) {

        $factory = new KazistFactory();


        $query = new Query();
        $query->select('jp.*');
        $query->from('#__jobs_packages', 'jp');
        $query->orderBy('jp.id ', 'DESC');

        $records = $query->loadObjectList();

        if ($fetch_prices) {
            $tmp_arr = array();
            foreach ($records as $key => $record) {
                $record->prices = $factory->getRecords('#__jobs_packages_prices', 'jpp', array('jpp.package_id=:package_id'), array('package_id' => $record->id));
                $tmp_arr[$record->id] = $record;
            }

            $records = $tmp_arr;
        }

        return $records;
    }

    public function getCertifications() {

        $tmparray = array();

        $factory = new KazistFactory();


        $query = new Query();
        $query->select('jc.id AS value, jc.title AS text');
        $query->from('#__jobs_certifications', 'jc');
        $query->orderBy('jc.title');



        $records = $query->loadObjectList();

        if (!empty($records)) {
            foreach ($records as $record) {
                $tmparray[] = array('value' => $record->value, 'text' => $record->text);
            }
        }

        return $tmparray;
    }

    public function getCountries() {

        $tmparray = array();

        $factory = new KazistFactory();


        $query = new Query();
        $query->select('swc.id AS value, swc.name AS text');
        $query->from('#__setup_countries', 'swc');
        $query->orderBy('swc.name');



        $records = $query->loadObjectList();

        if (!empty($records)) {
            foreach ($records as $record) {
                $tmparray[] = array('value' => $record->value, 'text' => $record->text);
            }
        }

        return $tmparray;
    }

    public function getLocations($country_id) {

        $tmparray = array();

        $factory = new KazistFactory();


        $query = new Query();
        $query->select('swr.id AS value, swr.name AS text');
        $query->from('#__setup_countries', 'swc');
        $query->leftJoin('swc', '#__setup_regions', 'swr', 'swc.code = swr.country');

        if ($country_id) {
            $query->where('swc.id=' . $country_id);
            $query->setParameter('country_id', (int) $country_id);
        } else {
            $query->where('1=-1');
        }
        $query->orderBy('swr.name');



        $records = $query->loadObjectList();

        if (!empty($records)) {
            foreach ($records as $record) {
                $tmparray[] = array('value' => $record->value, 'text' => $record->text);
            }
        }

        return $tmparray;
    }

    public function getPackagePrices() {

        $factory = new KazistFactory();


        $query = new Query();
        $query->select('jpp.*');
        $query->from('#__jobs_packages_prices', 'jpp');
        $query->orderBy('jpp.id ', 'DESC');



        $records = $query->loadObjectList();

        return $records;
    }

    public function getPackagePrice($package_price_id) {

        $factory = new KazistFactory();


        $query = new Query();
        $query->select('jpp.*');
        $query->from('#__jobs_packages_prices', 'jpp');

        if ($package_price_id) {
            $query->where('jpp.id=:package_price_id');
            $query->setParameter('package_price_id', $package_price_id);
        } else {
            $query->where('1=-1');
        }



        $records = $query->loadObject();


        return $records;
    }

    public function getDocuments($candidate_id) {

        $factory = new KazistFactory();

        $query = $factory->getQueryBuilder('#__jobs_candidates_documents', 'jcp');

        $query->where('jcp.candidate_id=:candidate_id');
        $query->setParameter('candidate_id', $candidate_id);
        $query->orderBy('jcp.id', 'DESC');

        $records = $query->loadObjectList();


        return $records;
    }

    public function getEducations($candidate_id) {

        $factory = new KazistFactory();

        $query = $factory->getQueryBuilder('#__jobs_candidates_education', 'jce');

        $query->where('jce.candidate_id=:candidate_id');
        $query->setParameter('candidate_id', $candidate_id);
        $query->orderBy('jce.id', 'DESC');

        $records = $query->loadObjectList();

        return $records;
    }

    public function getExperiences($candidate_id) {

        $factory = new KazistFactory();

        $query = $factory->getQueryBuilder('#__jobs_candidates_experiences', 'jce');

        $query->where('jce.candidate_id=:candidate_id');
        $query->setParameter('candidate_id', $candidate_id);
        $query->orderBy('jce.id ', 'DESC');

        $records = $query->loadObjectList();

        return $records;
    }

    public function getSkill($skill) {

        $factory = new KazistFactory();

        $query = $factory->getQueryBuilder('#__jobs_skills', 'js');

        $query->where('js.skill=:skill');
        $query->setParameter('skill', $skill);
        $query->orderBy('js.id ', 'DESC');

        $record = $query->loadObject();

        if (is_object($record)) {
            return $record->id;
        } else {

            $data_obj = new \stdClass();
            $data_obj->skill = $skill;
            $factory->saveRecord('#__jobs_skills', $data_obj);

            return $this->getSkill($skill);
        }

        return $record;
    }

    public function getSkills($candidate_id) {

        $factory = new KazistFactory();


        $query = new Query();
        $query->select('jcs.*, js.skill');
        $query->from('#__jobs_candidates_skills', 'jcs');
        $query->leftJoin('jcs', '#__jobs_skills', 'js', 'js.id = jcs.skill_id');
        $query->where('jcs.candidate_id=:candidate_id');
        $query->setParameter('candidate_id', $candidate_id);
        $query->orderBy('jcs.id', 'DESC');

        $records = $query->loadObjectList();

        return $records;
    }

    public function deleteDocument($document_id) {
        $factory = new KazistFactory();


        $query = new Query();
        $query->delete('#__jobs_candidates_documents');
        $query->where('id=:document_id');
        $query->setParameter('document_id', $document_id);

        $query->execute();
    }

    public function deleteExperiences($experience_id) {
        $factory = new KazistFactory();


        $query = new Query();
        $query->delete('#__jobs_candidates_experiences');
        $query->where('id=:experience_id');
        $query->setParameter('experience_id', $experience_id);



        $db->execute();
    }

    public function deleteEducations($education_id) {
        $factory = new KazistFactory();


        $query = new Query();
        $query->delete('#__jobs_candidates_education');
        $query->where('id=:education_id');
        $query->setParameter('education_id', $education_id);



        $db->execute();
    }

    public function loadCountryLocations() {

        $tmp_array = array();

        $factory = new KazistFactory();

        $country_id = $this->request->request->get('country_id');

        $locations = $this->getLocations($country_id);

        if (!empty($locations)) {
            foreach ($locations as $location) {
                $tmp_array[] = '<option value="' . $location['value'] . '">' . $location['text'] . '</option>';
            }
        }

        return json_encode($tmp_array);
    }

    public function loadCandidateDocuments() {
        $paths = array();

        $factory = new KazistFactory();


        $document_id = $this->request->request->get('document_id');
        $candidate_id = $this->request->request->get('candidate_id');

        $object_arr = new \stdClass();
        $object_arr->candidate_id = $candidate_id;
        $object_arr->document_id = $document_id;
        //$object_arr->item = $this->getSurvey($survey_id);

        $template = 'candidate.edit.documents.twig';
        $this->twig_paths[] = realpath(JPATH_ROOT . '/applications/Jobs/generalviews');

        $html = $factory->renderData($object_arr, $template, $paths);

        return $html;
    }

    public function processCandidateAnalyzer() {
        $candidateAnalyzer = new CandidateAnalyzer();
        $candidateAnalyzer->processCandidateAnalyzer();
    }

}
