<?php

/*
 * This file is part of Kazist Framework.
 * (c) Dedan Irungu <irungudedan@gmail.com>
 *  For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 * 
 */

/**
 * Description of JobsController
 *
 * @author sbc
 */

namespace Jobs\Jobs\Code\Controllers;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\Controller\BaseController;
use Jobs\Jobs\Code\Models\JobsModel;

class JobsController extends BaseController {

    public function indexAction() {

        $this->model = new JobsModel();

        $items = $this->model->getRecords();
        $items = $this->model->getAdditionalDetail($items);

        $data_arr['view'] = $this->request->get('view');
        $data_arr['items'] = $items;

        $this->html = $this->render('Jobs:Jobs:Code:views:table.index.twig', $data_arr);

        $response = $this->response($this->html);



        return $response;
    }

    public function detailAction() {

        $this->twig_paths[] = JPATH_ROOT . '/applications/Jobs/generalviews/';

        $this->model = new JobsModel();

        $item = $this->model->getRecord();
        $item = $this->model->getItemAdditionDetails($item);
        $packages = $this->model->getPackages(true);

        $data_arr['packages'] = $packages;
        $data_arr['item'] = $item;

        $this->container->get('document')->title = $item->title;
        $this->container->get('document')->description = ($item->short_description) ? $item->short_description : substr(strip_tags($item->article));
        $this->container->get('document')->image = WEB_ROOT . $item->image_file;
        $this->container->get('document')->type = 'job';

        $this->html = $this->render('Jobs:Jobs:Code:views:detail.index.twig', $data_arr);

        $response = $this->response($this->html);



        return $response;
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
                return $this->redirectToRoute('jobs.jobs.detail', array('id' => $id));
            }
        }
    }

}
