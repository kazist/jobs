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
use Jobs\Jobs\Code\Models\JobModel;
use Kazist\Service\Email\Email;
use Kazist\Service\Database\Query;

/**
 * Description of MarketplaceModel
 *
 * @author sbc
 */
class ApplicationsModel extends BaseModel {

    public $documents = array();

    public function save($form) {

        $factory = new KazistFactory();

        $id = $this->save($form);

        if ($id) {
            $msg = 'Job Save Successfully.';

            $factory->enqueueMessage($msg, 'info');
            $this->generateUrl('jobs.jobs.detail', array('id', $form['job_id']));

            $this->documents = array_merge($this->documents, $form['document']);

            $this->saveApplicationPhotos($id);
            $this->sendMessage($id, $form);
        } else {

            $msg = 'Saving Job Failed.';
            $factory->enqueueMessage($msg, 'info');
            $this->generateUrl('jobs.jobs.applications.edit');
        }

        return $redirect;
    }

    public function saveApplicationPhotos($job_id) {


        $factory = new KazistFactory();

        $media_ids = $factory->uploadMedia('upload');

        if (!empty($media_ids)) {
            foreach ($media_ids as $media_id) {
                $std_class = new \stdClass();

                $std_class->id = $job_id;
                $std_class->document = $media_id;

                $factory->saveRecord('#__jobs_candidates_documents', $std_class);
            }
        }

        $this->documents = array_merge($this->documents, $media_ids);
    }

    public function sendMessage($id, $form) {

        $tmp_array = array();
        $factory = new KazistFactory();
        $user = $factory->getUser();
        $email = new Email();

        $attachments = $this->getDocuments($form['job_id']);

        if ($this->sendMessageValidator($form)) {

            $tmp_array['job'] = $this->getJob($form['job_id']);
            $tmp_array['user'] = $this->getApplicationOwner($user->id);
            $tmp_array['message'] = $form;

            $email->sendDefinedLayoutEmail('jobs.jobs.applications.sendmessage', $tmp_array['user']->email, $tmp_array, $attachments);
            $email->sendDefinedLayoutEmail('jobs.jobs.applications.sendmessage.thankyou', $form['email'], $tmp_array, $attachments);
        }
    }

    public function sendMessageValidator($form) {

        $is_valid = true;

        return $is_valid;
    }

    public function getDocuments() {
        $documents = array();
        $factory = new KazistFactory();


        $query = new Query();
        $query->select('mm.*');
        $query->from('#__media_media', 'mm');
        $query->where('id IN (:ids)');
        $query->setParameter('ids', implode(', ', $this->documents));



        $records = $query->loadObjectList();

        if (!empty($records)) {
            foreach ($records as $key => $record) {
                $documents[] = JPATH_ROOT . '/' . $record->file;
            }
        }

        return $documents;
    }

    public function getJob($job_id) {

        $jobModel = new JobModel();
        $factory = new KazistFactory();

        $session = $factory->getSession();

        $uri = $session->get('uri');

        $query = new Query();
        $query->select('jj.*');
        $query->from('#__jobs_jobs', 'jj');
        if ($job_id) {
            $query->where('id=:job_id');
            $query->setParameter('job_id', $job_id);
        } else {
            $query->where('1=-1');
        }



        $record = $query->loadObject();

        $record->url = $this->generateUrl('jobs.jobs.detail', array('id', $job_id));

        return $jobModel->getItemAdditionDetails($record);
    }

    public function getApplicationOwner($created_by) {

        $factory = new KazistFactory();


        $query = new Query();
        $query->select('uu.*');
        $query->from('#__users_users', 'uu');
        if ($created_by) {
            $query->where('id=:created_by');
            $query->setParameter('created_by', $created_by);
        } else {
            $query->where('1=-1');
        }



        $record = $query->loadObject();

        return $record;
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


        $job_id = ($item->job_id) ? $item->job_id : $this->request->request->get('job_id');
        $item_obj = (is_object($item)) ? $item : new \stdClass();

        $item_obj->title = ucwords($item->title);
        $item_obj->job = $this->getJob($job_id);

        return $item_obj;
    }

    public function getCandidateDocuments() {

        $factory = new KazistFactory();


        $query = new Query();
        $query->select('jcd.*, mm.file as media_file, mm.title as media_title');
        $query->from('#__jobs_candidates_documents', 'jcd');
        $query->leftJoin('jcd', '#__media_media', 'mm', 'mm.id = jcd.document');

        $query->orderBy('id ', 'DESC');



        $record = $query->loadObjectList();

        return $record;
    }

}
