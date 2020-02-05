<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use bankApp\Database;
use bankApp\UserInfo;
use bankapp\Transaction;
use bankApp\BankTransaction;
use bankApp\SwishTransaction;

$db = new Database;
$userInfo = new UserInfo($db);
$bankType = new BankTransaction($db, $userInfo);
$swishType = new SwishTransaction($db, $userInfo);
$bankTransaction = new Transaction($db, $bankType, $userInfo);
$swishTransaction = new Transaction($db, $swishType, $userInfo);

if (isset($_POST["toUser"]) && isset($_POST["type"]) && isset($_POST["amount"])) { // check for post request and filter input
    $toUser = filter_input(INPUT_POST, "toUser", FILTER_SANITIZE_NUMBER_INT);
    $type = filter_input(INPUT_POST, "type", FILTER_SANITIZE_STRING);
    $amount = filter_input(INPUT_POST, "amount", FILTER_SANITIZE_NUMBER_INT);
    $fromUser = 3;
    try {
        if ($type === "Swish") { // try to send money
            $swishTransaction->sendMoney($fromUser, $toUser, $amount);
        } else {
            $bankTransaction->sendMoney($fromUser, $toUser, $amount);
        }
    } catch (Exception $e) { // error handler
        echo "<p>Something went wrong: " . $e->getMessage() . "</p>";
    }
}
