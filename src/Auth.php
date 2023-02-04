<?php

namespace src;

use modules\user\model\User;

class Auth
{
    public function checkLogin($username, $password)
    {
        $dbh = DatabaseConnection::getInstance();
        $dbc = $dbh->getConnection();

        $userObj = new User($dbc);
        $userObj->findBy('username', $username);

        if (property_exists($userObj, 'id')) {
            if (password_verify($password, $userObj->password)) {
                $_SESSION['name'] = $userObj->name;
                // all is good
                return true;
            }
        }
        return false;
    }

    public function changeUserPassword($userObj, $newPassword)
    {
        $userObj->password = password_hash($newPassword, PASSWORD_DEFAULT);

        return $userObj;
    }
}