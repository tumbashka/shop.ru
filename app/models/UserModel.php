<?php

namespace app\models;

use RedBeanPHP\R;

class UserModel extends AppModel
{

    public array $attributes = [
        'email' => '',
        'password' => '',
        'name' => '',
        'address' => '',
    ];

    public array $rules = [
        'required' => ['email', 'password', 'name', 'address'],
        'email' => ['email'],
        'lengthMin' => [
            ['password', 6],
            ['name', 2],
        ],
        'lengthMax' => [
            ['address', 255],
            ['name', 255],
            ['password', 255],
            ['email', 255],
        ],
        'optional' => ['email','password'],
    ];

    public array $labels = [
        'email' => 'tpl_signup_email_input',
        'password' => 'tpl_signup_password_input',
        'name' => 'tpl_signup_name_input',
        'address' => 'tpl_signup_address_input',
    ];

    public static function isAuthorized(): bool
    {
        return isset($_SESSION['user']);
    }

    public function isUniqueEmail($text_error = '')
    {
        $user = R::findOne('user', 'email = ?', [$this->attributes['email']]);
        if ($user) {
            $this->errors['unique'][] = $text_error ?: getLang('user_signup_error_email_unique');
            return false;
        } else {
            return true;
        }
    }

    public function signin($isAdmin = false): bool
    {
        $email = post('email');
        $password = post('password');
        if ($email && $password) {
            if ($isAdmin) {
                $user = R::findOne('user', "email = ? AND role = 'admin'", [$email]);
            } else {
                $user = R::findOne('user', "email = ?", [$email]);
            }
            if ($user) {
                if (password_verify($password, $user->password)) {
                    foreach ($user as $key => $value) {
                        if ($key != 'password') {
                            $_SESSION['user'][$key] = $value;
                        }
                    }
                    return true;
                }
            }
        }
        return false;
    }


}