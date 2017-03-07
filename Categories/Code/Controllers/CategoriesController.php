<?php

/*
 * This file is part of Kazist Framework.
 * (c) Dedan Irungu <irungudedan@gmail.com>
 *  For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 * 
 */

/**
 * Description of CategoriesController
 *
 * @author sbc
 */

namespace Jobs\Categories\Code\Controllers;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\Controller\BaseController;
use Jobs\Categories\Code\Models\CategoriesModel;

class CategoriesController extends BaseController {

    public function indexAction() {

        $this->model = new CategoriesModel();

        $categories = $this->model->getCategories();
        $items = $this->model->getRecords();

        $data_arr['items'] = $items;
        $data_arr['categories'] = $categories;

        $this->html = $this->render('Jobs:Categories:Code:views:table.index.twig', $data_arr);

        $response = $this->response($this->html);



        return $response;
    }

    public function detailAction() {

        $this->twig_paths[] = JPATH_ROOT . '/applications/Jobs/generalviews/';

        $this->model = new CategoriesModel();

        $item = $this->model->getRecord();
        $children = $this->model->getCategories($item->id);

        $data_arr['item'] = $item;
        $data_arr['children'] = $children;

        $this->html = $this->render('Jobs:Categories:Code:views:detail.index.twig', $data_arr);

        $response = $this->response($this->html);



        return $response;
    }

}
