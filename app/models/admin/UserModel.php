<?php

namespace app\models\admin;

class UserModel extends \app\models\UserModel
{
    public static function isAdmin(): bool
    {
        return (isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin');
    }
}