<?php

namespace app\controllers\admin;

use app\models\admin\OrderModel;
use app\models\admin\UserModel;
use tumba\App;
use tumba\Pagination;

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

    public function indexAction()
    {
        $page = get('page');
        $perPage = App::$appReg->getProperty('paginationAdminUsers');
        $total = $this->model->getUserCount();
        $pagination = new Pagination($page, $perPage, $total);
        $startID = $pagination->getStart();
        $users = $this->model->getUsers($startID, $perPage);

        $title = 'Пользователи';
        $this->setData(compact('users', 'title', 'total', 'pagination'));
        $this->setMeta("Админка - {$title}");
    }

    public function viewAction()
    {
        $id = get('id');
        $page = get('page');
        $perPage = App::$appReg->getProperty('paginationAdminOrders');
        $user = $this->model->getUser($id);
        $orderModel = new OrderModel();
        $total = $orderModel->getCountUserOrders($id);
        $pagination = new Pagination($page, $perPage, $total);
        $startID = $pagination->getStart();
        $orders = $orderModel->getUserOrders($id, $startID, $perPage);

        $title = 'Пользователь: ' . $user['name'];
        $this->setData(compact('title', 'user', 'orders', 'total', 'pagination'));
        $this->setMeta("Админка - {$title}");
    }

    public function editAction()
    {
        $id = get('id');
        $user = $this->model->getUser($id);
        if (empty($user)) {
            redirect(ADMIN . '/user');
        }
        if (!empty($_POST)) {
            $this->model->load();
            if (empty($this->model->attributes['password'])) {
                unset($this->model->attributes['password']);
            }
            if (!$this->model->validate($this->model->attributes) || !$this->model->checkEmail($user)) {
                $this->model->getErrors();
            } else {
                if (!empty($this->model->attributes['password'])) {
                    $this->model->attributes['password'] =
                        password_hash($this->model->attributes['password'], PASSWORD_DEFAULT);
                }
                if ($this->model->update('user', $id)) {
                    $_SESSION['success'] = 'Данные пользователя успешно обновлены';
                    if ($_SESSION['user']['id'] == $id) {
                        $_SESSION['user'] = $this->model->getUser($id);
                    }
                } else {
                    $_SESSION['errors'] = 'Ошибка обновления пользователя';
                }
            }
            redirect();
        }
        $title = 'Редактирование пользователя: ' . $user['name'];
        $this->setData(compact('user', 'title'));
        $this->setMeta("Админка - {$title}");
    }

    public function addAction()
    {
        if (!empty($_POST)) {
            $this->model->load();
            if (!$this->model->validate($this->model->attributes) ||
                !$this->model->isUniqueEmail('Данный email уже зарегестрирован')) {
                $this->model->getErrors();
                $_SESSION['form_data'] = $_POST;
            } else {
                $this->model->attributes['password'] = password_hash($this->model->attributes['password'], PASSWORD_DEFAULT);
                if ($this->model->save('user')) {
                    $_SESSION['success'] = 'Пользователь успешно добавлен';

                } else {
                    $_SESSION['errors'] = 'Ошибка добавления пользователя';
                }
                //               debug($_POST,1);
            }

            redirect();
        }

        $title = 'Создание нового пользователя';
        $this->setData(compact('title'));
        $this->setMeta("Админка - {$title}");
    }

}