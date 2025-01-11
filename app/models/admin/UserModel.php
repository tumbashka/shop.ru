<?php

namespace app\models\admin;

use RedBeanPHP\R;

class UserModel extends \app\models\UserModel
{
    public array $attributes = [
        'email' => '',
        'password' => '',
        'name' => '',
        'address' => '',
        'role' => '',
    ];

    public array $rules = [
        'required' => ['email', 'password', 'name', 'address', 'role',],
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
        'optional' => ['password'],
    ];

    public array $labels = [
        'email' => 'Email',
        'password' => 'Пароль',
        'name' => 'Имя',
        'address' => 'Адрес',
        'role' => 'Роль',
    ];

    public static function isAdmin(): bool
    {
        return (isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin');
    }

    public function getUser($id): array
    {
        $res = R::getRow("SELECT u.* FROM shop.user u WHERE u.id = ?", [$id]);
        unset($res['password']);
        return $res;
    }

    public function getUsers($startID, $perPage): array
    {
        return R::getAll("SELECT u.* FROM shop.user u LIMIT ?,?", [$startID, $perPage]);
    }

    public function getUserCount()
    {
        return R::count('user');
    }

    public function checkEmail($user_data): bool
    {
        if($user_data['email'] == $this->attributes['email']){
            return true;
        }
        $user = R::findOne('user', 'email = ?',[$this->attributes['email']]);
        if($user){
            $this->errors['unique'][] = 'Email уже занят';
            return false;
        }
        return true;
    }

}