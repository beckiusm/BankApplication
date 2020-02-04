<?php

namespace bankApp;

interface Transactions
{
    public function __construct(Database $db, Transaction $typeOfTransaction);

    public function checkBalance();

    public function getAccountCurrency($user);

    public function sendMoney($fromUser, $toUser, $value);
}
