<?php

namespace Logger;

use Data\DataManager;
use Webshop\AuthenticationManager;
use Webshop\BaseObject;

class LoggerManager extends BaseObject
{
    public static function logAction(string $action)
    {
        $user = AuthenticationManager::getAuthenticatedUser();
        $userName = isset($user) ? $user->getUserName() : "N/A";
        $ipAddress = ""; // LoggerManager::getRealIpAddr();

        DataManager::logAction($action, $ipAddress, $userName);
    }


    // private static function getRealIpAddr()
    // {
    //     if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    //         // Check IP from internet.
    //         $ip = $_SERVER['HTTP_CLIENT_IP'];
    //     } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    //         // Check IP is passed from proxy.
    //         $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    //     } else {
    //         // Get IP address from remote address.
    //         $ip = $_SERVER['REMOTE_ADDR'];
    //     }

    //     return $ip;
    // }
}