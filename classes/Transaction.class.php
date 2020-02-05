<?php

namespace bankApp;

use Exception;

class Transaction implements Transactions
{
    protected $db;
    protected $typeOfTransaction;
    protected $userInfo;
    protected $userId;
    
    public function __construct(Database $db, Transactions $typeOfTransaction, Userinfo $userInfo)
    {
        $this->db = $db->getDB();
        $this->userInfo = $userInfo;
        $this->typeOfTransaction = $typeOfTransaction->typeOfTransaction;
    }

    public function sendMoney($fromUser, $toUser, $amount)
    {
        if ($this->typeOfTransaction === "Swish") { // check if swish is used
            $toUser = $this->userInfo->getIdFromPhone($toUser);
        }
        $this->checkIfUserExists($toUser);
        if ($fromUser == $toUser) {
            throw new Exception("Can't send money to yourself");
        }
        $fromCurrency = $this->userInfo->getCurrency($fromUser); // get currency info from users
        $toCurrency = $this->userInfo->getCurrency($toUser);
        $toAmount = $this->convertCurrency($fromCurrency, $toCurrency, $amount);
        if ($amount > $this->userInfo->getBalance($fromUser)) { // check balance
            throw new \Exception("Insufficient funds.");
        } else {
            $stmt = $this->db->prepare("INSERT INTO transactions (from_amount, from_account, from_currency, to_amount, to_account, to_currency, currency_rate) 
            VALUES (:from_amount, :from_account, :from_currency, :to_amount, :to_account, :to_currency, :currency_rate)");
            $stmt->bindValue(":from_amount", $amount, \PDO::PARAM_INT);
            $stmt->bindValue(":from_account", $fromUser, \PDO::PARAM_INT);
            $stmt->bindValue(":from_currency", $fromCurrency, \PDO::PARAM_STR);
            $stmt->bindValue(":to_amount", $toAmount, \PDO::PARAM_INT);
            $stmt->bindValue(":to_account", $toUser, \PDO::PARAM_INT);
            $stmt->bindValue(":to_currency", $toCurrency, \PDO::PARAM_STR);
            $stmt->bindValue(":currency_rate", ($amount / $toAmount), \PDO::PARAM_STR);
            $stmt->execute();
            echo "<p>Sent $amount $fromCurrency to account id $toUser as a $this->typeOfTransaction transaction.</p>";
        }
    }

    public function checkIfUserExists($user) { // check if user exists
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$user]);
        if ($stmt->rowCount() === 0) {
            throw new \Exception("Specified user does not exist");
        }
    }

    public function convertCurrency($fromCurrency, $toCurrency, $amount) { // convert currency
        $convertedCurrency = json_decode(file_get_contents("https://api.exchangeratesapi.io/latest?base=" . $fromCurrency . "&symbols=" . $toCurrency));
        if ($amount > 0) {
            return ($amount * $convertedCurrency->rates->$toCurrency);
        } else {
            throw new \Exception("Amount must be larger than 0");
        }
    }
}
