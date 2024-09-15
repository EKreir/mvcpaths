<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Core\Auth\DbAuth;
use App;

class AppsController extends AppController {

    public function __construct()
    {
        parent::__construct();
        $app = App::getInstance();
        $auth = new DbAuth($app->getDb());

        if (!$auth->logged()) {
            $this->forbidden();
        }
    }

}