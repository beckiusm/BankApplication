<?php

// Klassen som hanterar överföringar ska ta emot ett typehintat interface i konstruktorn för olika betalningslösningar och låta minst två klasser implementera interfacet (t ex swish, banköverföring, betalkort).  

namespace bankApp;

use bankApp\Database;
use bankApp\Transactions;
use bankApp\UserInfo;

include("DB.class.php");
include("UserInfo.php");

class Transaction
{
    private $db;
    private $typeOfTransaction;
    private $userInfo;

    public function __construct(Database $db, Transaction $transactionType = NULL, Userinfo $userInfo)
    {
        $this->db = $db->getDB();
        $this->userInfo = $userInfo;
        $this->typeOfTransaction = $transactionType;
    }

    public function sendMoney($fromUser, $toUser, $amount)
    {
        $fromCurrency = $this->userInfo->getCurrency($fromUser);
        $toCurrency = $this->userInfo->getCurrency($toUser);
        $toAmount = $amount; // CURRENCY CONVERSION HERE
        if ($amount > $this->userInfo->getBalance($fromUser)) {
            throw new Exception();
        } else {
            $stmt = $this->db->prepare("INSERT INTO transactions (from_amount, from_account, from_currency, to_amount, to_account, to_currency, currency_rate) VALUES (:from_amount, :from_account, :from_currency, :to_amount, :to_account, :to_currency, :currency_rate)");
            $stmt->bindValue(":from_amount", $amount, PDO::PARAM_INT);
            $stmt->bindValue(":from_account", $fromUser, PDO::PARAM_INT);
            $stmt->bindValue(":from_currency", $fromCurrency, PDO::PARAM_STR);
            $stmt->bindValue(":to_amount", $toAmount, PDO::PARAM_INT);
            $stmt->bindValue(":to_account", $toUser, PDO::PARAM_INT);
            $stmt->bindValue(":to_currency", $toCurrency, PDO::PARAM_STR);
            $stmt->bindValue(":currency_rate", ($fromCurrency / $toCurrency), PDO::PARAM_STR);
        }
    }
}


$db = new Database;
$userInfo = new UserInfo();
$transaction = new Transaction($db, null, $userInfo);
$transaction->sendMoney(1, 2, 1000);
