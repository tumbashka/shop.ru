<?php

namespace app\controllers;


use app\models\UserModel;

/**
 * @property UserModel $model
 */
class UserController extends AppController
{
    public function signupAction()
    {
        if (UserModel::isAuthorized()) {
            redirect(base_url());
        }

        if (!empty($_POST)) {
            $data = $_POST;
            $this->model->load($data);
            if (!$this->model->validate($data) || !$this->model->isUniqueEmail()) {
                $this->model->getErrors();
                $_SESSION['form_data'] = $data;
            } else {
                $this->model->attributes['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                if ($this->model->save('user')) {
                    $_SESSION['success'] = getLang('user_signup_success_registration');
                } else{
                    $_SESSION['errors'] = getLang('user_signup_error_registration');
                }
            }
            redirect();
        }
        $this->setMeta(getLang('tpl_signup'));
    }

    public function signinAction()
    {
        if (UserModel::isAuthorized()) {
            redirect(base_url());
        }

        if (!empty($_POST)) {
            if($this->model->signin()){
                $_SESSION['success'] = getLang('user_signin_success_signin');
                redirect(base_url());
            }else{
                $_SESSION['errors'] = getLang('user_signin_error_signin');
                redirect();
            }

        }

        $this->setMeta(getLang('tpl_signin'));
    }

    public function logoutAction(){
        if (UserModel::isAuthorized()) {
            unset($_SESSION['user']);
            redirect(base_url().'user/signin');
        }
    }

}