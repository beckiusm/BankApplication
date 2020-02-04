<?php

// Klassen som hanterar överföringar ska ta emot ett typehintat interface i konstruktorn för olika betalningslösningar och låta minst två klasser implementera interfacet (t ex swish, banköverföring, betalkort).

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
