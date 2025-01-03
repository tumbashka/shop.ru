<?php

namespace app\controllers\admin;

use app\models\admin\UserModel;

/**
 * @property UserModel $model
 */
class UserController extends AppController
{
    public function signinAdminAction()
    {
        if ($this->model::isAdmin()) {
            redirect(ADMIN);
        }
        $this->layout = 'signin';

        if (!empty($_POST)) {
            if ($this->model->signin(true)) {
                $_SESSION['success'] = 'Вы успешно авторизованы';
                redirect(ADMIN);
            } else {
                $_SESSION['errors'] = 'Ошибка авторизации';
                redirect();
            }
        }
    }

    public function logoutAction()
    {
        unset($_SESSION['user']);
        redirect();
    }

}