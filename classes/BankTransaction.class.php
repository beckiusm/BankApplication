<?php

namespace bankApp;

class BankTransaction extends Transaction implements Transactions
{
    public $typeOfTransaction = "Bank";

    public function __construct(Database $db, UserInfo $userInfo)
    {
        $this->db = $db->getDB();
        $this->userInfo = $userInfo;
    }
    
}
