<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Jobs\Jobs\Code\Models;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\Model\BaseModel;
use Kazist\KazistFactory;
use Jobs\Addons\LatestjobsCode\Models\LatestjobsModel;
use Kazist\Service\Database\Query;

/**
 * Description of MarketplaceModel
 *
 * @author sbc
 */
class JobsModel extends BaseModel {

    public $redirect = '';

    public function appendSearchQuery($query) {

        $package_id = $this->request->request->get('package_id');
        $category_id = $this->request->request->get('category_id');

        if ($package_id) {
            $query->where('jj.package_id=' . $package_id);
        }
        if ($category_id) {
            $query->where('jj.category_id=' . $category_id);
        }

        $query->orderBy('jj.payment_status ', 'DESC');
        $query->orderBy('jj.date_created ', 'DESC');

        return $query;
    }

    public function save($form = '') {

        $document = $this->container->get('document');
        $factory = new KazistFactory();

        $default_gateway = $factory->getSetting('finance_gateway_default_gateway');

        $id = parent::save($form);

        if ($id) {
            $job = $this->getJob($id);
            $package_price = $this->getPackagePrice($job->package_price_id);

            $job->payment_amount = $package_price->price;
            $msg = 'Job Save Successfully.';

            $factory->saveRecord('#__jobs_jobs', $job);

            if ($form['new_payment'] || ($job->payment_amount && !$job->payment_status)) {
                $msg .= ' Proceed With Payment.';
                $factory->enqueueMessage($msg, 'info');
                $this->redirect = $this->generateUrl('finance.payments.newpayment', array(
                    'path' => 'jobs.jobs',
                    'gateway_id' => $default_gateway,
                    'pay_subset_id' => $document->subset_id,
                    'amount' => $job->payment_amount,
                    'item_id' => $job->id,
                    'description=' => 'Advert: ' . $form['title']
                ));
            } else {
                $factory->enqueueMessage($msg, 'info');
                $this->redirect = $this->generateUrl('jobs.jobs.detail', array('id', $id));
            }
        } else {

            $msg = 'Saving Job Failed.';
            $factory->enqueueMessage($msg, 'info');
            $this->redirect = $this->generateUrl('jobs.jobs.edit');
        }

        return $id;
    }

    public function saveImages($job_id) {

        $data_obj = new \stdClass();
        $factory = new KazistFactory();
        $media_ids = $factory->uploadMedia('form.image', 'jobs.jobs', $job_id);

        $data_obj->id = $job_id;
        $data_obj->image = (count($media_ids)) ? $media_ids[0] : 0;

        if ($data_obj->image) {
            $factory->saveRecord('#__jobs_jobs', $data_obj);
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
        $item_obj->category = $this->getCategoryName($item->category_id);
        $item_obj->country = $this->getCountryName($item->country_id);
        $item_obj->location = $this->getLocationName($item->location_id);

        //$item_obj->faqs = $this->getFaqs($item->id, 0, 3);

        return $item_obj;
    }

    public function getJobs($category_id, $offset = 0, $limit = 3) {

        $factory = new KazistFactory();

        $session = $factory->getSession();

        //$email->debug_exit = true;
        $uri = $session->get('uri');

        $query = new Query();
        $query->select('jj.*');
        $query->from('#__jobs_jobs', 'jj');

        if ($category_id) {
            $query->where('jj.category_id=:category_id');
            $query->setParameter('category_id', $category_id);
        }

        $query->orderBy('id ', 'DESC');

        $query->setFirstResult($offset);
        $query->setMaxResults($limit);

        $record = $query->loadObjectList();

        return $record;
    }

    public function getJob($job_id) {

        $factory = new KazistFactory();

        $session = $factory->getSession();

        //$email->debug_exit = true;
        $uri = $session->get('uri');

        $query = new Query();
        $query->select('jj.*');
        $query->from('#__jobs_jobs', 'jj');
        $query->where('id=:job_id');
        $query->setParameter('job_id', $job_id);

        $query->orderBy('id ', 'DESC');



        $record = $query->loadObject();

        return $record;
    }

    public function getJobLogo($item) {

        $factory = new KazistFactory();


        $query = new Query();
        $query->select('mm.file, mm.title');
        $query->from('#__jobs_jobs', 'jj');
        $query->leftJoin('jj', '#__media_media', 'mm', 'mm.id = jj.logo');
        if ($item->id) {
            $query->where('jj.id=:id');
            $query->setParameter('id', $item->id);
        } else {
            $query->where('1=-1');
        }



        $record = $query->loadObject();
        //print_r($record); exit;

        return $record;
    }

    public function getTotalJobs($category_id) {

        $factory = new KazistFactory();


        $query = new Query();
        $query->select('COUNT(*) AS total');
        $query->from('#__jobs_jobs', 'jj');

        if ($category_id) {
            $query->where('jj.category_id=:category_id');
            $query->setParameter('category_id', $category_id);
        }




        $record = $query->loadObject();

        return $record->total;
    }

    public function getLocationName($location_id) {

        $factory = new KazistFactory();


        $query = new Query();
        $query->select('swr.*');
        $query->from('#__setup_regions', 'swr');
        if ($location_id) {
            $query->where('swr.id=:location_id');
            $query->setParameter('location_id', $location_id);
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
            $query->where('swc.id=:country_id');
            $query->setParameter('country_id', $country_id);
        } else {
            $query->where('1=-1');
        }


        $record = $query->loadObject();

        return $record;
    }

    public function getCategoryName($category_id) {

        $factory = new KazistFactory();


        $query = new Query();
        $query->select('jc.*');
        $query->from('#__jobs_categories', 'jc');
        if ($category_id) {
            $query->where('jc.id=:id');
            $query->setParameter('id', $category_id);
        } else {
            $query->where('1=-1');
        }


        $record = $query->loadObject();

        return $record;
    }

    public function getPackagePrice($package_price_id) {

        $factory = new KazistFactory();


        $query = new Query();
        $query->select('jpp.*');
        $query->from('#__jobs_packages_prices', 'jpp');

        if ($package_price_id) {
            $query->where('jpp.id=:id');
            $query->setParameter('id', $package_price_id);
        } else {
            $query->where('1=-1');
        }



        $records = $query->loadObject();


        return $records;
    }

    public function getCategories($parent_id = '') {

        $factory = new KazistFactory();


        $query = new Query();
        $query->select('jc.*');
        $query->from('#__jobs_categories', 'jc');
        if ($parent_id) {
            $query->where('jc.parent_id=:parent_id');
            $query->setParameter('parent_id', $parent_id);
        } else {
            $query->where('jc.parent_id IS NULL OR jc.parent_id = 0');
        }
        $query->orderBy('jc.id ', 'DESC');



        $records = $query->loadObjectList();

        if (!empty($records)) {
            foreach ($records as $key => $record) {
                $records[$key]->children = $this->getCategories($record->id);
            }
        }

        return $records;
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

    public function getBusinesses() {

        $tmparray = array();

        $factory = new KazistFactory();

        $user = $factory->getUser();

        $query = new Query();
        $query->select('bb.id AS value, bb.name AS text');
        $query->from('#__businesses_businesses', 'bb');
        $query->where('bb.created_by=:user_id');
        $query->setParameter('user_id', $user->id);
        $query->orderBy('bb.id ', 'DESC');



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
        $query->LeftJoin('swc', '#__setup_regions', 'swr', 'swc.code = swr.country');
        if ($country_id) {
            $query->where('swc.id=:country_id');
            $query->setParameter('country_id', $country_id);
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

    public function loadBlockCategoryJobs() {

        $paths = array();

        $object_arr = new \stdClass();
        $factory = new KazistFactory();
        $latestjob_model = new LatestjobsModel();



        $category_id = $this->request->request->get('category_id');

        $object_arr->jobs = $latestjob_model->getLatestJobs($category_id, 6);

        $template = 'category.jobs.twig';
        $paths[] = JPATH_ROOT . '/applications/Jobs/Addons/Latestjobs/views';

        $html = $factory->renderData($object_arr, $template, $paths);

        return $html;
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

    public function loadCategoryJobs() {
        $paths = array();

        $object_arr = new \stdClass();
        $factory = new KazistFactory();


        $offset = $this->request->request->get('offset');
        $action = $this->request->request->get('action');

        $object_arr->category_id = $this->request->request->get('category_id');
        $object_arr->offset = ($action == 'previous') ? $offset - 3 : $offset + 3;

        $template = 'job.list.twig';
        $paths[] = realpath(JPATH_ROOT . '/applications/Jobs/generalviews');
        $html = $factory->renderData($object_arr, $template, $paths);

        return $html;
    }

}
