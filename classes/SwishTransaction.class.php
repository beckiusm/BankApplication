<?php

namespace bankApp;

class SwishTransaction extends Transaction implements Transactions
{
    public $typeOfTransaction = "Swish";

    public function __construct(Database $db, UserInfo $userInfo)
    {
        $this->db = $db->getDB();
        $this->userInfo = $userInfo;
    }
}
