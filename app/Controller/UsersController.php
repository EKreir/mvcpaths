<?php

namespace App\Controller;

use App\Controller\Admin\AppsController;
use Core\HTML\BootstrapForm;
use Core\Auth\DbAuth;
use App;

class UsersController extends AppsController {

    public function login()
    {
        $errors = false;
        if (!empty($_POST)) {
            $auth = new DbAuth(App::getInstance()->getDb());
            if ($auth->login($_POST['username'], $_POST['password'])) {
                header('Location: index.php?p=admin.posts.index');
            } else {
                $errors = true;
            }
        }
        $form = new BootstrapForm($_POST);
        $this->render('users.login', compact('form', 'errors'));
    }

}