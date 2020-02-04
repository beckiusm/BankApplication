<?php

namespace bankApp;

interface Transactions
{
    public function sendMoney($fromUser, $toUser, $value);

    public function checkIfUserExists($user);

    public function convertCurrency($fromCurrency, $toCurrency, $amount);
}
