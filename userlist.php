<?php

require_once(__DIR__ . '/vendor/autoload.php');

use bankApp\Database;
use bankApp\UserInfo;

$db = new Database;
$userInfo = new UserInfo($db);

echo $userInfo->getAllUsers();
