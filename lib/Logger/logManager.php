<?php

namespace Logger;

use Data\DataManager;
use Webshop\AuthenticationManager;
use Webshop\BaseObject;

class LogManager extends BaseObject
{
    public static function logAction(string $action)
    {
        $user = AuthenticationManager::getAuthenticatedUser();
        $userName = isset($user) ? $user->getUserName() : "N/A";
        $ipAddress = LogManager::getRealIpAddr();

        DataManager::logAction($action, $ipAddress, $userName);
    }

    private static function getRealIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }
}
