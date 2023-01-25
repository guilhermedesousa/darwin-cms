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
                // all is good
                return true;
            }
        }
    }

    public function changeUserPassword($userObj, $newPassword)
    {
        $userObj->password = password_hash($newPassword, PASSWORD_DEFAULT);

        return $userObj;
    }
}